<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use Illuminate\Support\Facades\Route;
use Modules\Inventario\Http\Controllers\CategoryController;
use Modules\Inventario\Http\Controllers\InventarioController;
use Modules\Inventario\Http\Controllers\ProductController;
use Modules\Reportes\Http\Controllers\ReportsController;
use Modules\Usuarios\Http\Controllers\UsersController;
use Modules\Ventas\Http\Controllers\CustomerController;
use Modules\Ventas\Http\Controllers\SalesController;

/* Route::get('/', function () {
    return view('welcome');
}); */

/* Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
}); */


Route::get('/', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('iniciar-sesion', [LoginController::class, 'login']);

Route::post('logout', [LoginController::class, 'logout'])
    ->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::middleware(['can:ventas'])->group(function () {
        Route::resource('ventas', SalesController::class);
        Route::get('ventas/data', [SalesController::class, 'dataTableSales'])->name('ventas.data');
        Route::post('ventas/{sale}/send-invoice', [SalesController::class, 'sendInvoice'])->name('ventas.send_invoice');
        Route::get('/ventas/{sale}/descargar-pdf', [SalesController::class, 'downloadPdf'])->name('ventas.download_pdf');
        Route::get('clients-get', [SalesController::class, 'getClientes']);
        Route::post('/customers', [CustomerController::class, 'store']);
        Route::get('/inventario', [SalesController::class, 'index'])->name('inventario.index');
    });



    Route::middleware(['can:inventarios'])->group(function () {
        Route::resource('categories', ProductController::class);
        Route::post('/categorias', [CategoryController::class, 'store'])->name('categories.store');
    });


    Route::resource('products', ProductController::class);


    Route::middleware(['can:reportes'])->group(function () {
        Route::get('/reportes', [ReportsController::class, 'index'])->name('reportes.index');
        Route::resource('reports', ReportsController::class);
        Route::get('/reports-get', [ReportsController::class, 'getReports'])->name('reports.get');
        Route::get('/reportes/export', [ReportsController::class, 'export'])->name('reportes.export');
        Route::get('/reportes', [ReportsController::class, 'index'])->name('reportes.index');
        Route::get('/reportes/export-pdf', [ReportsController::class, 'exportPdf'])->name('reportes.export_pdf');
    });

    Route::resource('usuarios', UsersController::class);
    Route::resource('roles', UsersController::class);
    Route::resource('permissions', UsersController::class);
    
    
    Route::get('/products-get', [InventarioController::class, 'getProducts'])->name('products.get');
    Route::get('/usuarios-get', [UsersController::class, 'getUsuarios'])->name('usuarios.get');

    

});