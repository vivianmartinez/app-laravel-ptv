<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class,'create']);
Route::post('/user',[LoginController::class,'login'])->name('login');
