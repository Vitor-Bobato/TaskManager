<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;

Route::get('/', function () {
    return view('welcome');
});


Route::get("login", [\App\Http\Controllers\AuthManager::class , "login"])->name("login");

