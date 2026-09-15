<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReturn;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    /**
     * Muestra el catálogo de productos disponibles.
     */
    public function catalog(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $products = Product::with('category')
            ->where('status', 'approved')
            ->where('stock', '>', 0)
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($category, function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('cliente.catalog', compact(
            'products',
            'categories',
            'search',
            'category'
        ));
    }

    /**
     * Historial de compras del cliente.
     */
    public function purchases(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('cliente.purchases', compact('orders'));
    }

    /**
     * Detalle de una compra en específico.
     */
    public function purchaseShow(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403, 'No tienes autorización para consultar esta compra.');
        }

        $order->load(['items.product', 'returns']);

        return view('cliente.purchase-show', compact('order'));
    }

    /**
     * Formulario para solicitar la devolución de un producto.
     */
    public function returnCreate(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403, 'No tienes autorización para solicitar una devolución de esta compra.');
        }

        $order->load('items.product');

        return view('cliente.returns.create', compact('order'));
    }

    /**
     * Procesa y almacena la solicitud de devolución.
     */
    public function returnStore(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403, 'No tienes autorización para solicitar una devolución de esta compra.');
        }

        $validated = $request->validate([
            'product_id' => [
                'required',
                'integer',
                Rule::exists('order_items', 'product_id')->where('order_id', $order->id),
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
            'reason' => [
                'required',
                'string',
                'min:10',
                'max:1000',
            ],
        ], [
            'product_id.exists' => 'El producto seleccionado no pertenece a esta orden de compra.',
        ]);

        $orderItem = $order->items()
            ->where('product_id', $validated['product_id'])
            ->firstOrFail();

        // Validar que la cantidad no supere lo comprado en el ítem de la orden
        if ((int) $validated['quantity'] > $orderItem->quantity) {
            return back()
                ->withErrors([
                    'quantity' => "La cantidad no puede superar las unidades compradas ({$orderItem->quantity}).",
                ])
                ->withInput();
        }

        // Prevenir solicitudes duplicadas en estado pendiente
        $hasPendingReturn = ProductReturn::where('order_id', $order->id)
            ->where('product_id', $validated['product_id'])
            ->where('status', 'pending')
            ->exists();

        if ($hasPendingReturn) {
            return back()
                ->withErrors([
                    'product_id' => 'Ya existe una solicitud de devolución pendiente para este producto.',
                ])
                ->withInput();
        }

        ProductReturn::create([
            'order_id' => $order->id,
            'user_id' => $request->user()->id,
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        return redirect()
            ->route('cliente.purchases.show', $order)
            ->with('success', 'La solicitud de devolución fue registrada correctamente y está pendiente de revisión.');
    }

    /**
     * Muestra las devoluciones solicitadas por el cliente.
     */
    public function returns(Request $request)
    {
        $returns = ProductReturn::with(['order', 'product'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('cliente.returns.index', compact('returns'));
    }
}




