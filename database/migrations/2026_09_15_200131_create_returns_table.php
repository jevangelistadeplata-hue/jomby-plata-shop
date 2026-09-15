<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración.
     */
    public function up(): void
    {
        Schema::create('returns', function (Blueprint $table) {

            // Identificador único de la devolución.
            $table->id();

            // Venta a la que pertenece la devolución.
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            // Cliente que solicita la devolución.
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            // Producto que será devuelto.
            $table->foreignId('product_id')
                ->constrained('products')
                ->restrictOnDelete();

            // Cantidad de unidades que se desean devolver.
            $table->unsignedInteger('quantity');

            // Motivo indicado por el cliente.
            $table->text('reason');

            // Estado actual de la solicitud.
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'completed',
            ])->default('pending');

            // Fecha en que se procesó la devolución.
            $table->timestamp('processed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};

