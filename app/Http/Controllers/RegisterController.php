<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth; // Para login automático, se desejar

class RegisterController extends Controller
{
    /**
     * Exibe o formulário de registro.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register'); // É comum colocar views de auth em uma subpasta 'auth'
    }

    /**
     * Armazena um novo usuário registrado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome_completo' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols(),
                'confirmed'
            ],
        ], [
            // Mensagens de erro personalizadas
            'nome_completo.required' => 'O nome completo é obrigatório.',
            'nome_completo.min' => 'O nome completo deve ter pelo menos 3 caracteres.',
            'nome_completo.max' => 'O nome completo não pode exceder 255 caracteres.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de email válido.',
            'email.unique' => 'Este endereço de email já está cadastrado.',
            'email.max' => 'O email não pode exceder 255 caracteres.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não coincide.',
            'password.mixedCase' => 'A senha deve conter letras maiúsculas e minúsculas.',
            'password.numbers' => 'A senha deve conter pelo menos um número.',
            'password.symbols' => 'A senha deve conter pelo menos um símbolo.',
            'password.letters' => 'A senha deve conter pelo menos uma letra.',
        ]);

        // Criação do usuário
        // Usamos $validatedData aqui para garantir que apenas dados validados sejam usados.
        $user = User::create([
            'nome_completo' => $validatedData['nome_completo'], // ou 'name' se for o nome da coluna no seu BD
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Opcional: Fazer login do usuário automaticamente após o registro
        // Auth::login($user);

        // Redirecionar para a página de login com uma mensagem de sucesso
        // Ou para o dashboard se o login automático for implementado: redirect()->route('dashboard')
        return redirect()->route('login')->with('success', 'Usuário registrado com sucesso! Por favor, faça o login.');
    }
}
