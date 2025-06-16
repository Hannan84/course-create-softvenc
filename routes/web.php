<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::get('/courses', [CourseController::class, 'index']);
Route::get('/', [CourseController::class, 'create']);
Route::post('/store', [CourseController::class, 'store']);
