<?php

namespace App\Http\Controllers;

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
        // Obtiene el carrito almacenado en la sesión.
        $cart = $request->session()->get('cart', []);

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

        // Obtiene el carrito actual de la sesión.
        $cart = $request->session()->get('cart', []);

        // Si el producto ya existe en el carrito, aumenta su cantidad.
        if (isset($cart[$product->id])) {

            $newQuantity = $cart[$product->id]['quantity'] + 1;

            // Impide agregar más unidades de las disponibles.
            if ($newQuantity > $product->stock) {
                return back()->with(
                    'error',
                    'No puedes agregar más unidades de las disponibles.'
                );
            }

            $cart[$product->id]['quantity'] = $newQuantity;

        } else {

            // Agrega el producto por primera vez al carrito.
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->sale_price,
                'quantity' => 1,
            ];
        }

        // Guarda nuevamente el carrito en la sesión.
        $request->session()->put('cart', $cart);

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
        // Obtiene el carrito actual de la sesión.
        $cart = $request->session()->get('cart', []);

        // Verifica que el producto exista en el carrito.
        if (! isset($cart[$product->id])) {
            return back()->with(
                'error',
                'El producto no se encuentra en el carrito.'
            );
        }

        // Calcula la nueva cantidad.
        $newQuantity = $cart[$product->id]['quantity'] + 1;

        // Verifica que exista suficiente stock.
        if ($newQuantity > $product->stock) {
            return back()->with(
                'error',
                'No puedes agregar más unidades de las disponibles.'
            );
        }

        // Actualiza la cantidad.
        $cart[$product->id]['quantity'] = $newQuantity;

        // Guarda el carrito actualizado.
        $request->session()->put('cart', $cart);

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
        // Obtiene el carrito actual de la sesión.
        $cart = $request->session()->get('cart', []);

        // Verifica que el producto exista en el carrito.
        if (! isset($cart[$product->id])) {
            return back()->with(
                'error',
                'El producto no se encuentra en el carrito.'
            );
        }

        // Disminuye la cantidad en una unidad.
        $cart[$product->id]['quantity']--;

        // Si la cantidad llega a cero, elimina el producto del carrito.
        if ($cart[$product->id]['quantity'] <= 0) {
            unset($cart[$product->id]);
        }

        // Guarda el carrito actualizado.
        $request->session()->put('cart', $cart);

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
        // Obtiene el carrito actual de la sesión.
        $cart = $request->session()->get('cart', []);

        // Verifica que el producto exista en el carrito.
        if (! isset($cart[$product->id])) {
            return back()->with(
                'error',
                'El producto no se encuentra en el carrito.'
            );
        }

        // Elimina completamente el producto del carrito.
        unset($cart[$product->id]);

        // Guarda el carrito actualizado.
        $request->session()->put('cart', $cart);

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
        // Obtiene el carrito almacenado en la sesión.
        $cart = $request->session()->get('cart', []);

        // Verifica que existan productos en el carrito.
        if (empty($cart)) {
            return back()->with(
                'error',
                'El carrito está vacío.'
            );
        }

        try {

            $order = DB::transaction(function () use ($cart, $request) {

                // Obtiene los identificadores de los productos del carrito.
                $productIds = array_keys($cart);

                // Consulta los productos directamente desde la base de datos.
                $products = Product::whereIn('id', $productIds)
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                $subtotal = 0;

                // Verifica cada producto y calcula el subtotal.
                foreach ($cart as $item) {

                    $productId = $item['product_id'];
                    $quantity = (int) $item['quantity'];

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
                            'El producto "' . $product->name . '" ya no está disponible para la venta.'
                        );
                    }

                    // Verifica que la cantidad solicitada sea válida.
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

                    // Calcula el subtotal usando el precio actual de la base de datos.
                    $subtotal += $product->sale_price * $quantity;
                }

                // En esta primera versión no se aplica impuesto.
                $tax = 0;

                // El total corresponde al subtotal más los impuestos.
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

                    $product = $products[$item['product_id']];
                    $quantity = (int) $item['quantity'];
                    $unitPrice = $product->sale_price;
                    $itemSubtotal = $unitPrice * $quantity;

                    $order->items()->create([
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'subtotal' => $itemSubtotal,
                    ]);

                    // Descuenta del inventario las unidades vendidas.
                    $product->decrement('stock', $quantity);
                }

                return $order;
            });

            // Limpia el carrito después de completar la venta.
            $request->session()->forget('cart');

            return redirect()
                ->route('cliente.dashboard')
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




