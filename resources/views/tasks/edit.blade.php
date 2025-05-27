<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarefa</title>
</head>
<body>
    <h1>Editar Tarefa</h1>
    <!-- Exibe mensagens de erro de validação, se houver -->
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="title">Título:</label><br>
        <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" required>
        <br><br>

        <label for="description">Descrição:</label><br>
        <textarea name="description" id="description">{{ old('description', $task->description) }}</textarea>
        <br><br>

        <button type="submit">Salvar</button>
        <a href="{{ route('tasks.index') }}">Cancelar</a>
    </form>
</body>
</html>