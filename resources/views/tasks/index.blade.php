<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskManager - Lista de Tarefas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #10B981;
            --primary-dark: #047857;
            --primary-light: #D1FAE5;
            --secondary: #3B82F6;
        }
        body { font-family: 'Poppins', sans-serif; background-color: #F9FAFB; }
        .task-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); transform-origin: center; }
        .task-card:hover { transform: translateY(-5px) scale(1.02); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);}
        .priority-high   { border-left-color: #EF4444; background: linear-gradient(to right,rgba(239,68,68,0.05) 0%,rgba(239,68,68,0.01) 100%);}
        .priority-medium { border-left-color: #F59E0B; background: linear-gradient(to right,rgba(245,158,11,0.05) 0%,rgba(245,158,11,0.01) 100%);}
        .priority-low    { border-left-color: #10B981; background: linear-gradient(to right,rgba(16,185,129,0.05) 0%,rgba(16,185,129,0.01) 100%);}
        .btn-action { transition: all 0.2s ease; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%;}
        .btn-action:hover { background-color: rgba(0,0,0,0.05); transform: scale(1.1);}
        .btn-create { position: relative; overflow: hidden; transition: all 0.3s ease;}
        .btn-create:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1),0 4px 6px -2px rgba(0,0,0,0.05);}
        .btn-create:active { transform: translateY(0);}
        .empty-state { animation: fadeIn 0.6s ease forwards;}
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px);} to { opacity: 1; transform: translateY(0);}}
        .task-complete { position: relative;}
        .task-complete.completed { text-decoration: line-through; color: #9ca3af;}
        .task-title { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 180px;}
        .task-description { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;}
        .view-details-btn { color: var(--secondary); cursor: pointer; font-size: 0.875rem; margin-top: 0.5rem; display: inline-flex; align-items: center;}
        .view-details-btn:hover { text-decoration: underline;}
    </style>
</head>
<body class="min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <header class="mb-8 bg-white rounded-xl shadow-sm p-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center mb-4 md:mb-0">
                    <i class="fas fa-tasks text-green-600 text-2xl mr-3"></i>
                    <h1 class="text-2xl font-bold text-gray-800">TaskManager</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('tasks.create') }}" class="btn-create bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg flex items-center">
                        <i class="fas fa-plus mr-2"></i>Criar tarefa
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-create bg-red-700 hover:bg-red-600 text-white px-6 py-3 rounded-lg flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i>Sair
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($tasks as $task)
                <div class="task-card bg-white rounded-xl shadow-md overflow-hidden border-l-4
                    @if($task->priority === 'Alta') priority-high
                    @elseif($task->priority === 'Media') priority-medium
                    @else priority-low
                    @endif">

                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center min-w-0">
                                <span class="bg-gray-100 text-gray-600 rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3">#{{ $loop->iteration }}</span>
                                <h3 class="font-bold text-xl text-gray-800 task-complete task-title {{ $task->completed ? 'completed' : '' }}" title="{{ $task->title }}">
                                    {{ $task->title }}
                                </h3>
                            </div>
                            <div class="flex space-x-2 flex-shrink-0">
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn-action text-gray-600 hover:text-green-600" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action text-gray-600 hover:text-red-600" title="Excluir">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <p class="text-gray-600 mb-4 task-description">{{ $task->description }}</p>

                        <div class="view-details-btn" onclick="showTaskDetails({{ json_encode($task) }})">
                            <i class="fas fa-eye mr-1"></i> Ver detalhes
                        </div>

                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="far fa-calendar-alt mr-2"></i>
                            {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Sem data limite' }}
                        </div>

                        <div class="flex items-center text-sm mb-4
                            @if($task->priority === 'Alta') text-red-600
                            @elseif($task->priority === 'Media') text-yellow-600
                            @else text-green-600
                            @endif">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            Prioridade: {{ $task->priority }}
                        </div>

                        <button
                            class="w-full py-2 px-4 rounded-lg transition-all duration-300 flex items-center justify-center complete-btn
                                {{ $task->completed ? 'bg-blue-600 hover:bg-blue-700' : 'bg-green-600 hover:bg-green-700' }}"
                            data-task-id="{{ $task->id }}"
                        >
                            {!! $task->completed
                                ? '<i class="fas fa-undo mr-2"></i> Reabrir'
                                : '<i class="fas fa-check mr-2"></i> Concluir'
                            !!}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        @if($tasks->isEmpty())
            <div class="empty-state text-center py-12 bg-white rounded-xl shadow-sm mt-8">
                <i class="fas fa-tasks text-5xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-medium text-gray-500 mb-4">Nenhuma tarefa encontrada</h3>
                <p class="text-gray-500 mb-6">Comece criando sua primeira tarefa para organizar seu dia</p>
                <a href="{{ route('tasks.create') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition-all duration-300 hover:scale-105">
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
                timer: 2000,
                background: '#F9FAFB',
                position: 'bottom-end',
                toast: true
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'OK',
                background: '#F9FAFB'
            });
        </script>
    @endif

    <script>
        // Confirmação para exclusão
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Esta ação não pode ser desfeita!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#15803d',
                    cancelButtonColor: '#b91c1c',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar',
                    background: '#F9FAFB'
                }).then((result) => { if (result.isConfirmed) this.submit(); });
            });
        });

        // AJAX para marcar/desmarcar task como concluída
        document.querySelectorAll('.complete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                const btn = this;
                fetch(`/tasks/${taskId}/toggle-complete`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.completed !== undefined) {
                        const taskCard = btn.closest('.task-card');
                        const taskTitle = taskCard.querySelector('.task-complete');
                        taskTitle.classList.toggle('completed', data.completed);

                        if (data.completed) {
                            btn.innerHTML = '<i class="fas fa-undo mr-2"></i> Reabrir';
                            btn.classList.remove('bg-green-600', 'hover:bg-green-700');
                            btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                        } else {
                            btn.innerHTML = '<i class="fas fa-check mr-2"></i> Concluir';
                            btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                            btn.classList.add('bg-green-600', 'hover:bg-green-700');
                        }
                    } else {
                        Swal.fire('Erro!', 'Não foi possível atualizar o status da tarefa.', 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('Erro!', 'Ocorreu um erro de comunicação.', 'error');
                });
            });
        });

        // Função para mostrar detalhes da tarefa
        function showTaskDetails(task) {
            Swal.fire({
                title: task.title,
                html: `
                    <div class="text-left">
                        <p class="mb-4">${task.description || 'Sem descrição'}</p>
                        <div class="flex items-center text-sm text-gray-600 mb-2">
                            <i class="far fa-calendar-alt mr-2"></i>
                            ${task.due_date ? new Date(task.due_date).toLocaleDateString('pt-BR') : 'Sem data limite'}
                        </div>
                        <div class="flex items-center text-sm mb-2
                            ${task.priority === 'Alta' ? 'text-red-600' :
                             task.priority === 'Media' ? 'text-yellow-600' : 'text-green-600'}">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            Prioridade: ${task.priority}
                        </div>
                    </div>
                `,
                confirmButtonText: 'Fechar',
                background: '#F9FAFB',
                width: '600px'
            });
        }
    </script>
</body>
</html>