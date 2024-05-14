<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class,'create']);
Route::post('/user',[LoginController::class,'handle'])->name('login');
Route::post('/register',[UserController::class,'store'])->name('user.store');
