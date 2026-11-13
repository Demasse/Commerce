<?php

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
