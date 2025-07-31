<?php

use Illuminate\Support\Facades\Route;
use Modules\Usuarios\Http\Controllers\UsersController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('usuarios', UsersController::class)->names('usuarios');
});
