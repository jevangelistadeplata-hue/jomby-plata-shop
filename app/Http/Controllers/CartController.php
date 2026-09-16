<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Muestra el carrito del cliente.
     */
    public function index(Request $request)
    {
        $cart = $request->user()
            ->cartItems()
            ->with('product')
            ->get();

        return view('cliente.cart', compact('cart'));
    }

    /**
     * Agrega un producto al carrito.
     */
    public function add(Request $request, Product $product)
    {
        // Verifica que el producto esté aprobado y tenga existencia.
        if ($product->status !== 'approved' || $product->stock <= 0) {
            return back()->with(
                'error',
                'El producto no está disponible para la venta.'
            );
        }

        // Busca el producto dentro del carrito del cliente.
        $cartItem = $request->user()
            ->cartItems()
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // Calcula la nueva cantidad.
            $newQuantity = $cartItem->quantity + 1;

            // Impide superar el stock disponible.
            if ($newQuantity > $product->stock) {
                return back()->with(
                    'error',
                    'No puedes agregar más unidades de las disponibles.'
                );
            }

            $cartItem->update([
                'quantity' => $newQuantity,
            ]);
        } else {
            // Agrega el producto por primera vez.
            $request->user()->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return back()->with(
            'success',
            'Producto agregado al carrito correctamente.'
        );
    }

    /**
     * Aumenta la cantidad de un producto del carrito.
     */
    public function increase(Request $request, Product $product)
    {
        $cartItem = $request->user()
            ->cartItems()
            ->where('product_id', $product->id)
            ->first();

        // Verifica que el producto exista en el carrito.
        if (! $cartItem) {
            return back()->with(
                'error',
                'El producto no se encuentra en el carrito.'
            );
        }

        // Calcula la nueva cantidad.
        $newQuantity = $cartItem->quantity + 1;

        // Verifica que exista suficiente stock.
        if ($newQuantity > $product->stock) {
            return back()->with(
                'error',
                'No puedes agregar más unidades de las disponibles.'
            );
        }

        $cartItem->update([
            'quantity' => $newQuantity,
        ]);

        return back()->with(
            'success',
            'Cantidad actualizada correctamente.'
        );
    }

    /**
     * Disminuye la cantidad de un producto del carrito.
     */
    public function decrease(Request $request, Product $product)
    {
        $cartItem = $request->user()
            ->cartItems()
            ->where('product_id', $product->id)
            ->first();

        // Verifica que el producto exista en el carrito.
        if (! $cartItem) {
            return back()->with(
                'error',
                'El producto no se encuentra en el carrito.'
            );
        }

        // Si hay una sola unidad, elimina el producto.
        if ($cartItem->quantity <= 1) {
            $cartItem->delete();
        } else {
            $cartItem->decrement('quantity');
        }

        return back()->with(
            'success',
            'Cantidad actualizada correctamente.'
        );
    }

    /**
     * Elimina un producto completamente del carrito.
     */
    public function remove(Request $request, Product $product)
    {
        $cartItem = $request->user()
            ->cartItems()
            ->where('product_id', $product->id)
            ->first();

        // Verifica que el producto exista en el carrito.
        if (! $cartItem) {
            return back()->with(
                'error',
                'El producto no se encuentra en el carrito.'
            );
        }

        $cartItem->delete();

        return back()->with(
            'success',
            'Producto eliminado del carrito correctamente.'
        );
    }

    /**
     * Convierte el carrito actual en una venta.
     */
    public function checkout(Request $request)
    {
        // Obtiene el carrito directamente desde la base de datos.
        $cart = $request->user()
            ->cartItems()
            ->with('product')
            ->get();

        // Verifica que existan productos en el carrito.
        if ($cart->isEmpty()) {
            return back()->with(
                'error',
                'El carrito está vacío.'
            );
        }

        try {
            $order = DB::transaction(function () use ($cart, $request) {

                // Obtiene los identificadores de los productos.
                $productIds = $cart->pluck('product_id')->all();

                // Consulta los productos y bloquea sus registros.
                $products = Product::whereIn('id', $productIds)
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                $subtotal = 0;

                // Verifica cada producto y calcula el subtotal.
                foreach ($cart as $item) {

                    $productId = $item->product_id;
                    $quantity = (int) $item->quantity;

                    // Verifica que el producto todavía exista.
                    if (! isset($products[$productId])) {
                        throw new \Exception(
                            'Uno de los productos del carrito ya no está disponible.'
                        );
                    }

                    $product = $products[$productId];

                    // Verifica que el producto siga aprobado.
                    if ($product->status !== 'approved') {
                        throw new \Exception(
                            'El producto "' .
                            $product->name .
                            '" ya no está disponible para la venta.'
                        );
                    }

                    // Verifica que la cantidad sea válida.
                    if ($quantity <= 0) {
                        throw new \Exception(
                            'La cantidad de un producto no es válida.'
                        );
                    }

                    // Verifica que exista suficiente stock.
                    if ($product->stock < $quantity) {
                        throw new \Exception(
                            'No hay suficiente stock para el producto "' .
                            $product->name .
                            '".'
                        );
                    }

                    // Calcula el subtotal usando el precio actual.
                    $subtotal += $product->sale_price * $quantity;
                }

                // En esta primera versión no se aplica impuesto.
                $tax = 0;

                // Calcula el total.
                $total = $subtotal + $tax;

                // Crea la venta.
                $order = Order::create([
                    'user_id' => $request->user()->id,
                    'status' => 'confirmed',
                    'payment_method' => 'cash',
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'total' => $total,
                ]);

                // Crea los detalles de la venta y descuenta el stock.
                foreach ($cart as $item) {

                    $product = $products[$item->product_id];
                    $quantity = (int) $item->quantity;

                    $unitPrice = $product->sale_price;
                    $costPrice = $product->cost_price;
                    $itemSubtotal = $unitPrice * $quantity;

                    $order->items()->create([
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'cost_price' => $costPrice,
                        'unit_price' => $unitPrice,
                        'subtotal' => $itemSubtotal,
                    ]);

                    // Descuenta del inventario las unidades vendidas.
                    $product->decrement('stock', $quantity);
                }

                // Vacía el carrito de este cliente.
                $request->user()
                    ->cartItems()
                    ->delete();

                return $order;
            });

            // Envía al cliente directamente a Mis compras.
            return redirect()
                ->route('cliente.purchases')
                ->with(
                    'success',
                    'Compra realizada correctamente. Número de venta: ' .
                    $order->order_number
                );

        } catch (\Exception $e) {

            // Devuelve al carrito cualquier error ocurrido durante la compra.
            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
}