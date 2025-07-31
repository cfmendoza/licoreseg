<?php

use Illuminate\Support\Facades\Route;
use Modules\Reportes\Http\Controllers\ReportsController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('reportes', ReportsController::class)->names('reportes');
});
