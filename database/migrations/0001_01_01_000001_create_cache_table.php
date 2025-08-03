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

    public function up(): void
    {
        Schema::create($this->prefix . 'cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create($this->prefix . 'cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->prefix . 'cache_locks');
        Schema::dropIfExists($this->prefix . 'cache');
    }
};
