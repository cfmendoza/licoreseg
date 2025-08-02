<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $prefix = env('DB_SINTAX', '');

        Schema::create($prefix . 'permissions', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        Schema::create($prefix . 'roles', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        Schema::create($prefix . 'model_has_permissions', static function (Blueprint $table) use ($prefix) {
            $table->unsignedBigInteger('permission_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->index(['model_id', 'model_type'], $prefix . 'model_has_permissions_model_id_model_type_index');

            $table->foreign('permission_id')
                ->references('id')
                ->on($prefix . 'permissions')
                ->onDelete('cascade');

            $table->primary(['permission_id', 'model_id', 'model_type'], $prefix . 'model_has_permissions_primary');
        });

        Schema::create($prefix . 'model_has_roles', static function (Blueprint $table) use ($prefix) {
            $table->unsignedBigInteger('role_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->index(['model_id', 'model_type'], $prefix . 'model_has_roles_model_id_model_type_index');

            $table->foreign('role_id')
                ->references('id')
                ->on($prefix . 'roles')
                ->onDelete('cascade');

            $table->primary(['role_id', 'model_id', 'model_type'], $prefix . 'model_has_roles_primary');
        });

        Schema::create($prefix . 'role_has_permissions', static function (Blueprint $table) use ($prefix) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on($prefix . 'permissions')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($prefix . 'roles')
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id'], $prefix . 'role_has_permissions_primary');
        });
    }

    public function down(): void
    {
        $prefix = env('DB_SINTAX', '');

        Schema::dropIfExists($prefix . 'role_has_permissions');
        Schema::dropIfExists($prefix . 'model_has_roles');
        Schema::dropIfExists($prefix . 'model_has_permissions');
        Schema::dropIfExists($prefix . 'roles');
        Schema::dropIfExists($prefix . 'permissions');
    }
};
