<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TaskManager</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Seus estilos existentes */
        .border-red-500 {
            border-color: #ef4444 !important;
        }
        .error-message {
            font-size: 0.875rem;
            color: #dc2626;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center font-sans">
<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
    <h1 class="text-2xl font-bold text-center mb-6 text-gray-700">Login</h1>

    <form method="POST" action="{{ route('login.store') }}" id="loginForm" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="text" id="email" name="email" value="{{ old('email') }}"
                   class="mt-1 block w-full px-3 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                   aria-describedby="email_error">
            @error('email')
            <p id="email_error" class="error-message" aria-live="polite">{{ $message }}</p>
            @enderror
            <p id="js_email_error" class="error-message" aria-live="polite"></p>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
            <input type="password" id="password" name="password"
                   class="mt-1 block w-full px-3 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                   aria-describedby="password_error">
            @error('password')
            <p id="password_error" class="error-message" aria-live="polite">{{ $message }}</p>
            @enderror
            <p id="js_password_error" class="error-message" aria-live="polite"></p>
        </div>

{{--        <div class="flex items-center justify-between">--}}
{{--            <div class="flex items-center">--}}
{{--                <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-green-700 focus:ring-green-600 border-gray-300 rounded">--}}
{{--                <label for="remember" class="ml-2 block text-sm text-gray-900">--}}
{{--                    Lembrar-me--}}
{{--                </label>--}}
{{--            </div>--}}
{{--        </div>--}}

        <button type="submit" class="w-full bg-green-700 text-white py-2 px-4 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600">
            Entrar
        </button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">
            Não tem uma conta?
            <a href="{{ route('register') }}" class="font-medium text-green-700 hover:text-green-600 hover:underline">
                Registre-se
            </a>
        </p>
    </div>
</div>

{{-- Script de validação JS (opcional) --}}
{{-- <script src="{{ asset('js/login-validation.js') }}"></script> --}}

@php
    // Mover a lógica da condição para um bloco @php
    // Isso ajuda o Blade a compilar de forma mais limpa, especialmente dentro de scripts.
    $shouldShowGeneralErrors = $errors->any() && !$errors->has('email') && old('email');
@endphp

<script>
    @if (session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Sucesso!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000
    });
    @endif

    @if (session('error_login'))
    Swal.fire({
        icon: 'error',
        title: 'Erro no Login',
        text: '{{ session('error_login') }}',
        confirmButtonText: 'OK'
    });
    @endif

    // Usar a variável PHP definida acima
    @if ($shouldShowGeneralErrors)
    let errorMessages = '';
    @foreach ($errors->all() as $error)

    errorMessages += `<p class="text-left">${@json($error)}</p>`;
    @endforeach
    Swal.fire({
        icon: 'error',
        title: 'Erro de Validação',
        html: errorMessages,
        confirmButtonText: 'OK',
        customClass: { htmlContainer: 'text-left' }
    });
    @endif
</script>
</body>
</html>
