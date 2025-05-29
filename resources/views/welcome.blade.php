<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Bem-vindo ao TaskManager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.5s ease forwards;
        }
        .animate-delay-100 { animation-delay: 0.1s; }
        .animate-delay-200 { animation-delay: 0.2s; }
        .animate-delay-300 { animation-delay: 0.3s; }
        .btn {
            padding-left: 1.5rem; /* px-6 */
            padding-right: 1.5rem; /* px-6 */
            padding-top: 0.75rem; /* py-3 */
            padding-bottom: 0.75rem; /* py-3 */
            border-radius: 0.5rem; /* rounded-lg */
            font-weight: 500; /* font-medium */
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* shadow-md */
            display: inline-flex; /* Para alinhar ícone e texto */
            align-items: center;
            text-decoration: none; /* Para tags <a> estilizadas como botões */
        }
        .btn:hover {
            transform: scale(1.05); /* hover:scale-105 */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* hover:shadow-lg */
        }
        .btn-green {
            background-color: #047857; /* bg-green-700 */
            color: white;
        }
        .btn-green:hover {
            background-color: #059669; /* hover:bg-green-600 */
        }
        .btn-blue { /* Exemplo de outra cor, se precisar diferenciar */
            background-color: #1d4ed8; /* bg-blue-700 */
            color: white;
        }
        .btn-blue:hover {
            background-color: #2563eb; /* hover:bg-blue-600 */
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
<div class="max-w-md w-full bg-white rounded-xl shadow-lg overflow-hidden p-8">
    <div class="text-center">
        <div class="animate-fadeIn animate-delay-100">
            <i class="fas fa-tasks text-5xl text-green-700 mb-4"></i>
            <h1 class="text-3xl font-bold text-gray-800 mb-3">Bem-vindo ao <span class="text-green-700">TaskManager</span></h1>
        </div>

        <div class="animate-fadeIn animate-delay-200">
            <p class="text-gray-600 mb-4">
                O <strong class="text-green-700">TaskManager</strong> ajuda você a organizar tarefas e compromissos.
            </p>
            <h2 class="text-xl font-semibold text-gray-800 mb-3">Principais funcionalidades:</h2>
            <ul class="space-y-2 mb-6 text-left max-w-xs mx-auto">
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-700 mt-1 mr-2"></i>
                    <span>Cadastro de tarefas</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-700 mt-1 mr-2"></i>
                    <span>Definição de prioridades</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-700 mt-1 mr-2"></i>
                    <span>Gestão de prazos</span>
                </li>
            </ul>
        </div>

        <div class="animate-fadeIn animate-delay-300 mt-8 space-y-4 sm:space-y-0 sm:space-x-4 flex flex-col sm:flex-row justify-center">
            <a href="{{ route('login') }}" class="btn btn-green">
                <i class="fas fa-sign-in-alt mr-2"></i> Entrar (Login)
            </a>
            <a href="{{ route('register') }}" class="btn btn-blue"> <i class="fas fa-user-plus mr-2"></i> Registrar
            </a>
        </div>
    </div>
</div>
</body>
</html>
