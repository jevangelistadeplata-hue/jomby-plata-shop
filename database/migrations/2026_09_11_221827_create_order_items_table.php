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
        Schema::create('orders', function (Blueprint $table) {

            // Identificador único de la venta.
            $table->id();

            // Número único de la venta.
            $table->string('order_number')->unique();

            // Cliente que realizó la compra.
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            // Estado actual de la venta.
            $table->enum('status', [
                'pending',
                'confirmed',
                'completed',
                'cancelled',
            ])->default('pending');

            // Método utilizado para realizar el pago.
            $table->enum('payment_method', [
                'cash',
                'card',
                'transfer',
            ])->default('cash');

            // Subtotal de la venta antes de impuestos.
            $table->decimal('subtotal', 12, 2)->default(0);

            // Impuestos de la venta.
            $table->decimal('tax', 12, 2)->default(0);

            // Total de la venta.
            $table->decimal('total', 12, 2)->default(0);

            // Observaciones adicionales de la venta.
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};