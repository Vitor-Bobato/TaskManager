<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Essencial para autenticação
use Illuminate\Support\Facades\Validator; // Para validação

class LoginController extends Controller
{
    /**
     * Exibe o formulário de login.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Assumindo que você criará a view em resources/views/auth/login.blade.php
        // Se estiver em resources/views/login.blade.php, use view('login')
        return view('auth.login');
    }

    /**
     * Lida com uma tentativa de autenticação.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validar os dados de entrada
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de email válido.',
            'password.required' => 'O campo senha é obrigatório.',
        ]);

        // 2. Tentar autenticar o usuário
        // O método Auth::attempt espera um array de credenciais.
        // Ele automaticamente fará o hash da senha fornecida e comparará com a senha hashada no banco.
        // O segundo parâmetro ($request->boolean('remember')) é para a funcionalidade "Lembrar-me", se você a implementar.
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // 3. Se a autenticação for bem-sucedida:
            $request->session()->regenerate(); // Regenera o ID da sessão para segurança

            // Redireciona para uma rota protegida, como um painel (dashboard)
            // Certifique-se de que a rota 'dashboard' existe ou mude para a rota desejada.
            return redirect()->intended('tasks')->with('success', 'Login realizado com sucesso!');
        }

        // 4. Se a autenticação falhar:
        // Volta para a página de login com os erros de validação (especificamente um erro para 'email')
        // e com os dados antigos (exceto a senha).
        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    /**
     * Faz logout do usuário.
     * (Você adicionará a rota para este método depois)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Você foi desconectado com sucesso!');
    }
}
