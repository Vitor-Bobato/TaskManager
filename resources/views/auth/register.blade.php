<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - TaskManager</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .border-red-500 {
            border-color: #ef4444 !important;
            animation: shake 0.5s;
        }

        .border-green-500 {
            border-color: #10b981 !important;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
    <h1 class="text-2xl font-bold text-center mb-6">Registrar Usuário</h1>

    <form method="POST" action="{{ route('register.store') }}" id="registerForm" class="space-y-4">
        @csrf

        <!-- Nome Completo -->
        <div>
            <label for="nome_completo" class="block text-sm font-medium text-gray-700">Nome Completo</label>
            <input type="text" id="nome_completo" name="nome_completo" value="{{ old('nome_completo') }}"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="text" id="email" name="email" value="{{ old('email') }}"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Senha -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
            <input type="password" id="password" name="password"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Confirmação de Senha -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Senha</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <button type="submit" class="w-full bg-green-700 text-white py-2 px-4 rounded-md hover:bg-green-600">
            Registrar
        </button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">
            Já tem uma conta?
            <a href="{{ route('login') }}" class="font-medium text-green-700 hover:text-green-600 hover:underline">
                Faça login
            </a>
        </p>
    </div>
</div>

<!-- Script de validação externo -->
<script src="{{ asset('js/register-validation.js') }}"></script>

<!-- Mensagens do backend -->
<script>
    @if ($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Erro!',
        html: `@foreach ($errors->all() as $error)
        • {{ $error }}<br>
            @endforeach`,
        confirmButtonText: 'OK'
    });
    @endif

    @if (session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Sucesso!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000
    });
    @endif
</script>
</body>
</html>
