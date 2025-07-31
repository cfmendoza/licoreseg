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
        Schema::create(env('DB_SINTAX') . 'products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price_sale', 10, 2)->default(0);     // Precio de venta
            $table->decimal('price_purchase', 10, 2)->default(0); // Precio de compra
            $table->integer('stock')->default(0);
            $table->string('brand')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id', 'fk_category_id')->references('id')->on(env('DB_SINTAX') . 'categories')->onDelete('restrict')->onUpdate('restrict');
            $table->string('presentation')->nullable();
            $table->integer('content')->nullable();
            $table->date('expiration_date')->nullable();
            $table->string('barcode')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(env('DB_SINTAX') . 'products');
    }
};
