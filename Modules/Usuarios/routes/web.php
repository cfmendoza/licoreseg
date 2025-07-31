<?php

use Illuminate\Support\Facades\Route;
use Modules\Usuarios\Http\Controllers\UsersController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('usuarios', UsersController::class)->names('usuarios');
});
