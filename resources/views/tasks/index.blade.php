<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskManager - Lista de Tarefas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .task-card {
            transition: all 0.3s ease;
        }
        .task-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-200 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <header class="mb-8 bg-white rounded-xl shadow-sm p-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-tasks text-green-700 mr-2"></i>
                    TaskManager
                </h1>
                <a href="{{ route('tasks.create') }}" class="bg-green-700 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-all duration-300 hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>Criar tarefa
                </a>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($tasks as $task)
                <div class="task-card bg-white rounded-xl shadow-md overflow-hidden border-l-4 
                    @if($task->priority === 'Alta') border-red-800
                    @elseif($task->priority === 'Média') border-yellow-700
                    @else border-green-700
                    @endif">
                    
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-bold text-xl text-gray-800 flex items-center">
                                <span class="bg-gray-100 text-gray-600 rounded-full w-6 h-6 flex items-center justify-center text-sm mr-2">#</span>
                                {{ $task->title }}
                            </h3>
                            <div class="flex space-x-2">
                                <a href="{{ route('tasks.edit', $task->id) }}" class="text-gray-600 hover:text-green-700" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta tarefa?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-600 hover:text-red-700" title="Excluir">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <p class="text-gray-600 mb-4">{{ $task->description }}</p>
                        
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="far fa-calendar-alt mr-2"></i>
                            {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Sem data limite' }}
                        </div>
                        
                        <div class="flex items-center text-sm mb-4
                            @if($task->priority === 'Alta') text-red-800
                            @elseif($task->priority === 'Média') text-yellow-700
                            @else text-green-700
                            @endif">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            Prioridade: {{ $task->priority }}
                        </div>
                        
                        <button class="w-full bg-green-700 hover:bg-green-600 text-white py-2 px-4 rounded-lg transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-check mr-2"></i> Concluir
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        @if($tasks->isEmpty())
            <div class="text-center py-12 bg-white rounded-xl shadow-sm mt-8">
                <i class="fas fa-tasks text-5xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-medium text-gray-500 mb-2">Nenhuma tarefa encontrada</h3>
                <a href="{{ route('tasks.create') }}" class="inline-block bg-green-700 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-all duration-300 hover:scale-105">
                    <i class="fas fa-plus mr-2"></i> Criar primeira tarefa
                </a>
            </div>
        @endif
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'OK'
            });
        </script>
    @endif
</body>
</html>