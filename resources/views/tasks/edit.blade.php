<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Editar Task</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            color: #222;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        h1 {
            color: #2d7fff;
            text-align: center;
            margin-top: 30px;
        }
        form {
            background: #fff;
            border-radius: 10px;
            max-width: 400px;
            margin: 40px auto 0 auto;
            box-shadow: 0 4px 16px rgba(45,127,255,.08);
            padding: 30px 35px 25px 35px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            animation: fadeIn 0.7s;
        }
        label {
            font-weight: bold;
            color: #2d7fff;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="date"], select, textarea {
            border: 1px solid #d9d9d9;
            border-radius: 6px;
            padding: 8px 10px;
            font-size: 1rem;
            transition: box-shadow 0.2s;
        }
        input[type="text"]:focus, input[type="date"]:focus, select:focus, textarea:focus {
            box-shadow: 0 0 0 2px #2d7fff44;
            outline: none;
        }
        textarea {
            min-height: 80px;
            max-height: 250px;
            resize: vertical;
        }
        .input-group {
            display: flex;
            flex-direction: column;
        }
        .char-counter {
            font-size: 0.9em;
            color: #888;
            margin-top: 3px;
            margin-bottom: 0;
            text-align: right;
            transition: color 0.2s;
        }
        .char-counter.over {
            color: #ff3d3d;
            font-weight: bold;
        }
        button[type="submit"] {
            background: linear-gradient(90deg, #2d7fff 60%, #1a5fcc 100%);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 1.08rem;
            padding: 10px 0;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.2s, transform 0.1s;
        }
        button[type="submit"]:hover {
            background: linear-gradient(90deg, #1a5fcc 60%, #2d7fff 100%);
            transform: translateY(-2px) scale(1.03);
        }
        a {
            display: block;
            text-align: center;
            color: #2d7fff;
            margin: 18px 0 0 0;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.2s;
        }
        a:hover {
            color: #1a5fcc;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(40px);}
            to { opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
    <h1>Editar Task</h1>
    <form id="taskForm" method="POST" action="{{ route('tasks.update', $task->id) }}">
        @csrf
        @method('PUT')

        <div class="input-group">
            <label for="title">Título da Task*</label>
            <input type="text" id="title" name="title" maxlength="50" required autocomplete="off"
                value="{{ old('title', $task->title) }}" oninput="updateCharCounter('title', 50)">
            <div class="char-counter" id="counter-title">0/50</div>
        </div>

        <div class="input-group">
            <label for="description">Descrição da Task</label>
            <textarea id="description" name="description" maxlength="500" autocomplete="off"
                oninput="updateCharCounter('description', 500)">{{ old('description', $task->description) }}</textarea>
            <div class="char-counter" id="counter-description">0/500</div>
        </div>

        <div class="input-group">
            <label for="due_date">Data Limite*</label>
            <input type="date" id="due_date" name="due_date" required
                value="{{ old('due_date', $task->due_date) }}">
        </div>

        <div class="input-group">
            <label for="priority">Prioridade*</label>
            <select id="priority" name="priority" required>
                <option value="" {{ old('priority', $task->priority) == "" ? 'selected' : '' }}>Selecione a prioridade</option>
                <option value="Alta" {{ old('priority', $task->priority) == "Alta" ? 'selected' : '' }}>Alta</option>
                <option value="Média" {{ old('priority', $task->priority) == "Média" ? 'selected' : '' }}>Média</option>
                <option value="Baixa" {{ old('priority', $task->priority) == "Baixa" ? 'selected' : '' }}>Baixa</option>
            </select>
        </div>

        <button type="submit">Salvar</button>
    </form>
    <a href="{{ route('tasks.index') }}">Voltar</a>

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

    <script>
        // Set min date to today
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            const minDate = `${yyyy}-${mm}-${dd}`;
            document.getElementById('due_date').setAttribute('min', minDate);

            updateCharCounter('title', 50);
            updateCharCounter('description', 500);
        });

        function updateCharCounter(field, max) {
            const input = document.getElementById(field);
            const counter = document.getElementById('counter-' + field);
            let val = input.value.length;
            counter.textContent = val + '/' + max;
            if (val > max) {
                counter.classList.add('over');
            } else {
                counter.classList.remove('over');
            }
        }

        document.getElementById('taskForm').addEventListener('submit', function(e) {
            // Título
            const title = document.getElementById('title').value.trim();
            if (!title) {
                showError("O campo <b>Título da Task</b> é obrigatório e não pode estar em branco.");
                e.preventDefault();
                return;
            }
            if (title.length > 50) {
                showError("O campo <b>Título da Task</b> deve ter no máximo 50 caracteres.");
                e.preventDefault();
                return;
            }

            // Descrição
            const desc = document.getElementById('description').value.trim();
            if (desc.length > 500) {
                showError("A <b>Descrição da Task</b> deve ter no máximo 500 caracteres.");
                e.preventDefault();
                return;
            }

            // Data Limite
            const dueDate = document.getElementById('due_date').value;
            if (!dueDate) {
                showError("O campo <b>Data Limite</b> é obrigatório.");
                e.preventDefault();
                return;
            }
            const today = new Date();
            const selected = new Date(dueDate);
            today.setHours(0,0,0,0); selected.setHours(0,0,0,0);
            if (selected < today) {
                showError("A <b>Data Limite</b> deve ser hoje ou uma data futura.");
                e.preventDefault();
                return;
            }

            // Prioridade
            const priority = document.getElementById('priority').value;
            if (!priority) {
                showError("O campo <b>Prioridade</b> é obrigatório.");
                e.preventDefault();
                return;
            }
        });

        function showError(msg) {
            Swal.fire({
                icon: 'error',
                title: 'Erro no formulário',
                html: msg,
                confirmButtonText: 'OK'
            });
        }
    </script>
</body>
</html>