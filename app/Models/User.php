<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Un usuario pertenece a un rol.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Un usuario puede tener un proveedor.
     */
    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class);
    }

    /**
     * Verifica si el usuario es Administrador.
     */
    public function isAdmin(): bool
    {
        return $this->role?->name === 'Administrador';
    }

    /**
     * Verifica si el usuario es Proveedor.
     */
    public function isSupplier(): bool
    {
        return $this->role?->name === 'Proveedor';
    }

    /**
     * Verifica si el usuario es Cliente.
     */
    public function isClient(): bool
    {
        return $this->role?->name === 'Cliente';
    }

    /**
     * Un usuario puede tener varios productos guardados en su carrito.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}