<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($task) ? 'Editar' : 'Criar' }} Tarefa - TaskManager</title>
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
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F9FAFB;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .form-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            animation: fadeInUp 0.6s ease;
            overflow: hidden;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .form-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }
        
        .form-body {
            padding: 2rem;
        }
        
        .form-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .form-subtitle {
            font-size: 0.875rem;
            opacity: 0.8;
        }
        
        .input-group {
            margin-bottom: 1.5rem;
        }
        
        .input-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }
        
        .input-label.required:after {
            content: '*';
            color: #EF4444;
            margin-left: 0.25rem;
        }
        
        .input-field {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #E5E7EB;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }
        
        .input-field:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }
        
        .char-counter {
            font-size: 0.75rem;
            color: #6B7280;
            text-align: right;
            margin-top: 0.25rem;
        }
        
        .char-counter.over {
            color: #EF4444;
            font-weight: 500;
        }
        
        .btn-submit {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .btn-submit:active {
            transform: translateY(0);
        }
        
        .btn-back {
            display: inline-flex;
            align-items: center;
            color: var(--primary);
            font-weight: 500;
            margin-top: 1.5rem;
            transition: all 0.2s ease;
        }
        
        .btn-back:hover {
            color: var(--primary-dark);
            transform: translateX(-3px);
        }
        
        .priority-high {
            color: #EF4444;
        }
        
        .priority-medium {
            color: #F59E0B;
        }
        
        .priority-low {
            color: #10B981;
        }
    </style>
</head>
<body>
    <div class="container mx-auto px-4 py-8 max-w-md">
        <div class="form-container">
            <div class="form-header">
                <h1 class="form-title">
                    <i class="fas fa-tasks mr-2"></i>
                    {{ isset($task) ? 'Editar Tarefa' : 'Criar Nova Tarefa' }}
                </h1>
                <p class="form-subtitle">Preencha os detalhes da tarefa abaixo</p>
            </div>
            
            <div class="form-body">
                <form id="taskForm" method="POST" action="{{ isset($task) ? route('tasks.update', $task->id) : route('tasks.store') }}">
                    @csrf
                    @if(isset($task))
                        @method('PUT')
                    @endif

                    <div class="input-group">
                        <label for="title" class="input-label required">Título da Tarefa</label>
                        <input type="text" id="title" name="title" class="input-field" 
                               value="{{ old('title', isset($task) ? $task->title : '') }}" 
                               maxlength="50" required autocomplete="off" 
                               oninput="updateCharCounter('title', 50)">
                        <div class="char-counter" id="counter-title">0/50</div>
                    </div>

                    <div class="input-group">
                        <label for="description" class="input-label">Descrição (opcional)</label>
                        <textarea id="description" name="description" class="input-field" rows="4"
                                  maxlength="500" oninput="updateCharCounter('description', 500)">{{ old('description', isset($task) ? $task->description : '') }}</textarea>
                        <div class="char-counter" id="counter-description">0/500</div>
                    </div>

                    <div class="input-group">
                        <label for="due_date" class="input-label">Data Limite (opcional)</label>
                        <input type="date" id="due_date" name="due_date" class="input-field" 
                               value="{{ old('due_date', isset($task) ? $task->due_date : '') }}">
                    </div>

                    <div class="input-group">
                        <label for="priority" class="input-label">Prioridade (opcional)</label>
                        <select id="priority" name="priority" class="input-field">
                            <option value="Baixa" {{ old('priority', isset($task) ? $task->priority : 'Baixa') == 'Baixa' ? 'selected' : '' }} class="priority-low">Baixa (padrão)</option>
                            <option value="Alta" {{ old('priority', isset($task) ? $task->priority : '') == 'Alta' ? 'selected' : '' }} class="priority-high">Alta</option>
                            <option value="Media" {{ old('priority', isset($task) ? $task->priority : '') == 'Media' ? 'selected' : '' }} class="priority-medium">Média</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save mr-2"></i>
                        {{ isset($task) ? 'Atualizar Tarefa' : 'Criar Tarefa' }}
                    </button>
                </form>

                <a href="{{ route('tasks.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left mr-2"></i> Voltar para a lista
                </a>
            </div>
        </div>
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
                position: 'top-end',
                toast: true
            });
        </script>
    @endif

    @if ($errors->any()))
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
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize counters
            updateCharCounter('title', 50);
            updateCharCounter('description', 500);
        });

        function updateCharCounter(field, max) {
            const input = document.getElementById(field);
            const counter = document.getElementById('counter-' + field);
            const length = input.value.length;
            counter.textContent = `${length}/${max}`;
            
            if (length > max) {
                counter.classList.add('over');
                input.classList.add('border-red-500');
                input.classList.remove('border-gray-300');
            } else {
                counter.classList.remove('over');
                input.classList.remove('border-red-500');
                input.classList.add('border-gray-300');
            }
        }

        // Form validation
        document.getElementById('taskForm').addEventListener('submit', function(e) {
            let isValid = true;
            const title = document.getElementById('title').value.trim();
            const description = document.getElementById('description').value.trim();
            
            // Title validation (only required field)
            if (!title) {
                showError('title', 'O título é obrigatório');
                isValid = false;
            } else if (title.length > 50) {
                showError('title', 'O título deve ter no máximo 50 caracteres');
                isValid = false;
            }
            
            // Description validation
            if (description.length > 500) {
                showError('description', 'A descrição deve ter no máximo 500 caracteres');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Formulário inválido',
                    text: 'Por favor, corrija os erros destacados',
                    confirmButtonText: 'OK',
                    background: '#F9FAFB'
                });
            }
        });
        
        function showError(fieldId, message) {
            const field = document.getElementById(fieldId);
            field.classList.add('border-red-500');
            
            let errorElement = document.getElementById(`error-${fieldId}`);
            if (!errorElement) {
                errorElement = document.createElement('div');
                errorElement.id = `error-${fieldId}`;
                errorElement.className = 'text-red-500 text-sm mt-1';
                field.parentNode.insertBefore(errorElement, field.nextSibling);
            }
            
            errorElement.textContent = message;
        }
    </script>
</body>
</html> 