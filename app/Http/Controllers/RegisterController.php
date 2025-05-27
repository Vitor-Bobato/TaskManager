<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Adicione esta linha
use Illuminate\Support\Facades\Hash; // E esta também
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome_completo' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8'
        ], [
            'password.min' => 'A senha deve ter no mínimo 8 caracteres',
            'email.unique' => 'Este email já está cadastrado'
        ]);

        User::create([
            'nome_completo' => $request->nome_completo,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Log::info('Novo usuário registrado', [
            'email' => $request->email,
            'ip' => $request->ip()
        ]);

        return redirect()->route('register')->with('success', 'Usuário registrado com sucesso!');
    }
}
