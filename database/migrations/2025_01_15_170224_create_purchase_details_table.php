<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id');
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('quantity');
            $table->decimal('price');

            // Asegurarse de que 'size_id' pueda ser nulo antes de agregar la clave foránea
            $table->unsignedBigInteger('size_id')->nullable();
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Primero eliminamos la clave foránea antes de eliminar la tabla
        Schema::table('purchase_details', function (Blueprint $table) {
            $table->dropForeign(['purchase_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['size_id']);
        });

        // Luego eliminamos la tabla 'purchase_details'
        Schema::dropIfExists('purchase_details');
    }
};
