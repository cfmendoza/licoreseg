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
        Schema::create($this->prefix . 'inventory_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id', 'fk_product_in_id')
                ->references('id')
                ->on($this->prefix . 'products')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->integer('quantity');
            $table->date('date');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'fk_user_in_id')
                ->references('id')
                ->on($this->prefix . 'users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->enum('movement_type', ['purchase', 'adjustment', 'return', 'other']);
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->prefix . 'inventory_entries');
    }
};
