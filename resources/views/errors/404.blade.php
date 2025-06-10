<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página Não Encontrada</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #10B981;
            --primary-dark: #047857;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #F3F4F6 0%, #E5E7EB 100%);
        }

        .btn-home {
            background-color: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-home:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in-up {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }

    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4">
<div class="text-center">
    <h1 class="fade-in-up text-9xl font-extrabold text-green-600 tracking-wider">404</h1>

    <h2 class="fade-in-up delay-1 mt-4 text-3xl font-bold text-gray-800 tracking-tight sm:text-4xl">
        Página Não Encontrada
    </h2>

    <p class="fade-in-up delay-2 mt-6 text-base leading-7 text-gray-600">
        Desculpe, não conseguimos encontrar a página que você está procurando.
    </p>

    <div class="fade-in-up delay-4 mt-10">
        <a href="{{ route('welcome') }}" class="btn-home">
            <i class="fas fa-home mr-2"></i>
            Voltar para a Página Inicial
        </a>
    </div>
</div>
</body>
</html>
