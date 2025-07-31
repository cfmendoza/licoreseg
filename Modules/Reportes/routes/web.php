<?php

use Illuminate\Support\Facades\Route;
use Modules\Reportes\Http\Controllers\ReportsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('reportes', ReportsController::class)->names('reportes');
});
