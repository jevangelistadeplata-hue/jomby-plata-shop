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
        Schema::table('order_items', function (Blueprint $table) {

            // Guarda el costo del producto al momento de realizar la venta.
            $table->decimal('cost_price', 12, 2)
                ->after('quantity');
        });
    }

    /**
     * Revierte la migración.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {

            // Elimina el costo registrado en el detalle de la venta.
            $table->dropColumn('cost_price');
        });
    }
};
