<?php

use App\Http\Controllers\VentaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/tutorial', function () {
    return view('tutorial');
})->middleware(['auth', 'verified'])->name('tutorial');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::resource('/productos', ProductoController::class);
    // Route::resource('/proveedors', ProveedorController::class);
    // Route::resource('/categorias', CategoriaController::class);
    // Route::resource('/ventas', VentaController::class);
    // Route::resource('/compras', CompraController::class);
    
});

require __DIR__.'/auth.php';

Route::middleware(['auth','admin'])->group(function () {
    Route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    
});
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'admin'])->name('admin.dashboard');
Route::get('/admin/tutorial', function () {
    return view('tutorial');
})->middleware(['auth', 'admin'])->name('admin.tutorial');


Route::resource('/productos', ProductoController::class);
Route::get('admin/productos/create', [ProductoController::class, 'create'])->name('productos.create');
    Route::resource('/proveedors', ProveedorController::class);
    Route::resource('/categorias', CategoriaController::class);
    Route::resource('/ventas', VentaController::class);
    Route::resource('/compras', CompraController::class);
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/{id}/toggle', [UserController::class, 'toggleStatus'])->name('admin.users.toggleStatus');
    Route::post('/proveedors/{id}/toggle', [ProveedorController::class, 'toggleStatus'])->name('proveedors.toggleStatus');
    Route::post('/categorias/{id}/toggle', [CategoriaController::class, 'toggleStatus'])->name('categorias.toggleStatus');