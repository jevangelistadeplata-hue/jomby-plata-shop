<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    /**
     * El artículo del carrito pertenece a un usuario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * El artículo del carrito pertenece a un producto.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}