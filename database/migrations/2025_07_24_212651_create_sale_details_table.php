<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected string $prefix;

    public function __construct()
    {
        $this->prefix = env('DB_SINTAX', '');
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->prefix . 'sale_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->foreign('sale_id', 'fk_sale_id')
                ->references('id')
                ->on($this->prefix . 'sales')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id', 'fk_product_id')
                ->references('id')
                ->on($this->prefix . 'products')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->prefix . 'sale_details');
    }
};
