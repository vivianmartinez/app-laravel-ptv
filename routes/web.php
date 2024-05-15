<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class,'create']);
Route::post('/user',[LoginController::class,'handle'])->name('login');
Route::post('/submit',[UserController::class,'store'])->name('user.store');
Route::get('/user/sign/{filename}',[UserController::class,'getUserSign'])->name('user.sign');
