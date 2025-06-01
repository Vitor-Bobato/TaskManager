<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController; // Adicionado: Importar o LoginController

// Rotas públicas
Route::get ('/', function () { return view('welcome'); })->name('welcome');
// Registro de usuário
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
// Rotas de login
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
// Rota de logout
Route::post ('/logout', [LoginController::class, 'destroy'])->name('logout');

// Rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

});

//Route::get('/', function () {
//    return view('welcome');
//})->name('welcome');
//
//Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
//Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
//Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

//Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
//Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
//
//// Rotas de criação de usuário

//
//// Rotas de Login

//
//// Poderíamos adicionar a rota de logout aqui também no futuro
//// Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
