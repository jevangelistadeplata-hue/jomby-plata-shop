<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductReturn extends Model
{
    use HasFactory;

    /**
     * Indica el nombre real de la tabla utilizada por el modelo.
     */
    protected $table = 'returns';

    /**
     * Campos que pueden asignarse masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'user_id',
        'product_id',
        'quantity',
        'reason',
        'status',
        'processed_at',
    ];

    /**
     * Casting de los atributos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
        'processed_at' => 'datetime',
    ];

    /**
     * La devolución pertenece a una venta.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * La devolución pertenece a un usuario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * La devolución pertenece a un producto.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

