<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Bem-vindo ao TaskManager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #10B981;
            --primary-dark: #047857;
            --primary-light: #D1FAE5;
            --secondary: #3B82F6;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #F3F4F6 0%, #E5E7EB 100%);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.6s ease forwards;
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        .animate-delay-100 { animation-delay: 0.1s; }
        .animate-delay-200 { animation-delay: 0.2s; }
        .animate-delay-300 { animation-delay: 0.3s; }
        
        .btn {
            position: relative;
            overflow: hidden;
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
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .btn-green {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-green:hover {
            background-color: var(--primary-dark);
        }
        
        .btn-blue {
            background-color: var(--secondary);
            color: white;
        }
        
        .btn-blue:hover {
            background-color: #2563EB;
        }
        
        .btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }
        
        .btn:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }
        
        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            100% {
                transform: scale(25, 25);
                opacity: 0;
            }
        }
        
        .feature-card {
            transition: all 0.3s ease;
            background: white;
            border-radius: 0.5rem;
            padding: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-4xl w-full bg-white rounded-2xl shadow-xl overflow-hidden p-8 md:p-10">
        <div class="text-center">
            <div class="animate-fadeIn animate-delay-100">
                <div class="animate-float inline-block">
                    <i class="fas fa-tasks text-6xl text-green-600 mb-4"></i>
                </div>
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Bem-vindo ao <span class="text-green-600">TaskManager</span></h1>
            </div>

            <div class="animate-fadeIn animate-delay-200">
                <p class="text-gray-600 mb-8 text-lg">
                    O <strong class="text-green-600">TaskManager</strong> ajuda você a organizar tarefas e compromissos de forma simples e eficiente.
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="feature-card animate-fadeIn">
                        <i class="fas fa-check-circle text-green-600 text-2xl mb-2"></i>
                        <h3 class="font-semibold text-gray-800">Cadastro de tarefas</h3>
                        <p class="text-gray-600 text-sm">Organize suas atividades diárias</p>
                    </div>
                    <div class="feature-card animate-fadeIn animate-delay-100">
                        <i class="fas fa-flag text-yellow-500 text-2xl mb-2"></i>
                        <h3 class="font-semibold text-gray-800">Definição de prioridades</h3>
                        <p class="text-gray-600 text-sm">Foque no que é mais importante</p>
                    </div>
                    <div class="feature-card animate-fadeIn animate-delay-200">
                        <i class="fas fa-calendar-day text-blue-500 text-2xl mb-2"></i>
                        <h3 class="font-semibold text-gray-800">Gestão de prazos</h3>
                        <p class="text-gray-600 text-sm">Nunca perca um prazo novamente</p>
                    </div>
                </div>
            </div>

            <div class="animate-fadeIn animate-delay-300 mt-8 space-y-4 sm:space-y-0 sm:space-x-4 flex flex-col sm:flex-row justify-center">
                <a href="{{ route('login') }}" class="btn btn-green">
                    <i class="fas fa-sign-in-alt mr-2"></i> Entrar
                </a>
                <a href="{{ route('register') }}" class="btn btn-blue">
                    <i class="fas fa-user-plus mr-2"></i> Criar conta
                </a>
            </div>
        </div>
    </div>
    
    <script>
        // Adiciona efeito de ripple aos botões
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Efeito visual antes de redirecionar
                this.style.transform = 'scale(0.95)';
                
                setTimeout(() => {
                    window.location.href = this.getAttribute('href');
                }, 200);
            });
        });
    </script>
</body>
</html>