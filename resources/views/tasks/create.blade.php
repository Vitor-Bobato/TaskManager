
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>create</title>
</head>
<body>

    <h1>Criar Task</h1>

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf

        <label>Título:</label>
        <input type="text" name="title" required><br>

        <label>Descrição:</label>
        <textarea name="description" required></textarea><br>

        <label>Data limite:</label>
        <input type="date" name="due_date"><br>

        <label>Prioridade:</label>
        <select name="priority" required>
            <option value="Alta">Alta</option>
            <option value="Média" selected>Média</option>
            <option value="Baixa">Baixa</option>
        </select><br><br>

        <button type="submit">Salvar</button>
    </form>

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


    <a href="{{ route('tasks.index') }}">Voltar</a>

</body>
</html>
