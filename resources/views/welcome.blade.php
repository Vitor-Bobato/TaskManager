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
            
            <div class="animate-fadeIn animate-delay-300 mt-8">
                <form action="{{ route('tasks.index') }}">
                    <button class="bg-green-700 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:scale-105 shadow-md hover:shadow-lg flex items-center mx-auto" type="submit">
                        <i class="fas fa-play mr-2"></i> Começar
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>