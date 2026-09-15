<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * Campos que pueden asignarse masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'cost_price',
        'unit_price',
        'subtotal',
    ];

    /**
     * Casting de atributos para asegurar tipos de datos correctos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
        'cost_price' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Boot del modelo para automatizar el cálculo del subtotal antes de guardar.
     */
    protected static function booted(): void
    {
        static::saving(function (OrderItem $item) {
            $item->subtotal = $item->quantity * $item->unit_price;
        });
    }

    /**
     * Indica que el detalle pertenece a una venta.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Indica que el detalle pertenece a un producto.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
