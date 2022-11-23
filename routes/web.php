<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;


//admin routes
Route::get("admin",[AdminController::class,'index'])->name('admin');
Route::Post("login",[AdminController::class,"Login"])->name('login');
Route::get("deshboard",[AdminController::class,"DeshBoard"])->name('deshboard');
