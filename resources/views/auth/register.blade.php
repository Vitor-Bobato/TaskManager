<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - TaskManager</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Seus estilos existentes aqui... */
        .border-red-500 {
            border-color: #ef4444 !important;
            /* animation: shake 0.5s; */ /* Removido shake para simplificar, adicione se quiser */
        }
        .border-green-500 {
            border-color: #10b981 !important;
        }
        /* @keyframes shake { ... } */ /* Removido shake */
        .error-message {
            font-size: 0.875rem; /* text-sm */
            color: #dc2626; /* text-red-600 */
            margin-top: 0.25rem; /* mt-1 */
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center font-sans">
<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
    <h1 class="text-2xl font-bold text-center mb-6 text-gray-700">Registrar Usuário</h1>

    <form method="POST" action="{{ route('register.store') }}" id="registerForm" class="space-y-4">
        @csrf

        <div>
            <label for="nome_completo" class="block text-sm font-medium text-gray-700">Nome Completo</label>
            <input type="text" id="nome_completo" name="nome_completo" value="{{ old('nome_completo') }}"
                   class="mt-1 block w-full px-3 py-2 border @error('nome_completo') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                   aria-describedby="nome_completo_error">
            @error('nome_completo')
            <p id="nome_completo_error" class="error-message" aria-live="polite">{{ $message }}</p>
            @else
                <p id="nome_completo_error" class="error-message" aria-live="polite"></p> {{-- Placeholder para JS --}}
                @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="text" id="email" name="email" value="{{ old('email') }}"
                   class="mt-1 block w-full px-3 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                   aria-describedby="email_error">
            @error('email')
            <p id="email_error" class="error-message" aria-live="polite">{{ $message }}</p>
            @else
                <p id="email_error" class="error-message" aria-live="polite"></p> {{-- Placeholder para JS --}}
                @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
            <input type="password" id="password" name="password"
                   class="mt-1 block w-full px-3 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                   aria-describedby="password_error">
            @error('password')
            <p id="password_error" class="error-message" aria-live="polite">{{ $message }}</p>
            @else
                <p id="password_error" class="error-message" aria-live="polite"></p> {{-- Placeholder para JS --}}
                @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Senha</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   class="mt-1 block w-full px-3 py-2 border @error('password_confirmation') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                   aria-describedby="password_confirmation_error">
            @error('password_confirmation') {{-- Erro de 'confirmed' aparece no campo original 'password', mas podemos adicionar um específico se houver --}}
            <p id="password_confirmation_error" class="error-message" aria-live="polite">{{ $message }}</p>
            @else
                <p id="password_confirmation_error" class="error-message" aria-live="polite"></p> {{-- Placeholder para JS --}}
                @enderror
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Registrar
        </button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">
            Já tem uma conta?
            <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 hover:underline">
                Faça login
            </a>
        </p>
    </div>

</div>

<script src="{{ asset('js/register-validation.js') }}"></script>

@php
    // Condição para o SweetAlert de erros gerais, evitando duplicar se só houver erros já mostrados inline.
    // Esta lógica é opcional. Se preferir, pode sempre mostrar o SweetAlert com todos os erros.
    $inlineErrors = ['nome_completo', 'email', 'password', 'password_confirmation'];
    $hasOnlyInlineHandledErrors = true;
    if ($errors->any()) {
        foreach ($errors->keys() as $key) {
            if (!in_array($key, $inlineErrors)) {
                $hasOnlyInlineHandledErrors = false;
                break;
            }
        }
        // Se todos os erros são para campos que têm @error, e você quer evitar o SweetAlert
        // if ($errors->keys() === array_intersect($errors->keys(), $inlineErrors)) {
        //    $hasOnlyInlineHandledErrors = true;
        // }
    } else {
        $hasOnlyInlineHandledErrors = false; // Não há erros, não mostrar SweetAlert de erro
    }
@endphp

<script>
    @if ($errors->any()) // Sempre verificar se há algum erro para o SweetAlert geral
    Swal.fire({
        icon: 'error',
        title: 'Erro de Validação!', // Título mais genérico para o popup
        html: `@foreach ($errors->all() as $error)
        <p class="text-left">{{ $error }}</p>
            @endforeach`,
        confirmButtonText: 'OK',
        customClass: {
            htmlContainer: 'text-left'
        }
    });
    @endif

    @if (session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Sucesso!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2500
    });
    @endif
</script>
</body>
</html>
