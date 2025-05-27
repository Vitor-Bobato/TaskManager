<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RegisterController;

Route::get('/', [TaskController::class, 'index'])-> name ('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])-> name ('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])-> name ('tasks.store');
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

// Rotas de criação de usuário
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
