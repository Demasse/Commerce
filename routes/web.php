<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

route::get('/students', [StudentController::class, 'index']);
route::post('/students', [StudentController::class, 'store']);
route::delete('/students/{student}', [StudentController::class, 'destroy']);
