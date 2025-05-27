<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Registro</title>
</head>
<body>
<h1>Registrar Usuário</h1>

<form method="POST" action="{{ route('register.store') }}">
    @csrf

    <label>Nome Completo:</label>
    <input type="text" name="nome_completo" value="{{ old('nome_completo') }}" required><br>

    <label>Email:</label>
    <input type="email" name="email" value="{{ old('email') }}" required><br>

    <label>Senha:</label>
    <input type="password" name="password" required><br>

    <button type="submit">Registrar</button>
</form>

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            window.location.href = '/'; // Redireciona após fechar
        });
    </script>
@endif

@if ($errors->any()))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Erro no Registro!',
        html: `@foreach ($errors->all() as $error)
        • {{ $error }}<br>
                @endforeach`,
        confirmButtonText: 'OK'
    });
</script>
@endif
</body>
</html>
