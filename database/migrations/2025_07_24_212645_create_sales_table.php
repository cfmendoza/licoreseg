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
        Schema::create(env('DB_SINTAX') . 'sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id', 'fk_customer_id')->references('id')->on(env('DB_SINTAX') . 'customers')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'fk_user_id')->references('id')->on(env('DB_SINTAX') . 'users')->onDelete('restrict')->onUpdate('restrict');
            $table->dateTime('date');
            $table->decimal('total', 10, 2);
            $table->enum('status', ['finalized', 'cancelled'])->default('finalized');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(env('DB_SINTAX') . 'sales');
    }
};
