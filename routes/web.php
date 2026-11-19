<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StudentController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

route::get('/students', [StudentController::class, 'index']);
route::post('/students', [StudentController::class, 'store']);
route::delete('/students/{student}', [StudentController::class, 'destroy']);

route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');


route::get('/', [ProductController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
    Route::post('/panier/ajouter', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/panier/item/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/panier/item/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
});
