<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar - TaskManager</title>
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
            background: linear-gradient(135deg, #F3F4F6 0%, #E5E7EB 100%);
            min-height: 100vh;
        }
        
        .auth-container {
            animation: fadeInUp 0.6s ease;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .auth-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        .auth-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .auth-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-15px); }
            60% { transform: translateY(-7px); }
        }
        
        .auth-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .auth-subtitle {
            font-size: 0.875rem;
            opacity: 0.9;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .input-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }
        
        .input-field {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
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
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
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
            margin-top: 0.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .btn-submit:active {
            transform: translateY(0);
        }
        
        .btn-submit::after {
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
        
        .btn-submit:focus:not(:active)::after {
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
        
        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #6B7280;
        }
        
        .auth-link {
            color: var(--primary);
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .auth-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            cursor: pointer;
        }
        
        .error-message {
            font-size: 0.75rem;
            color: #EF4444;
            margin-top: 0.25rem;
        }
        
        .input-error {
            border-color: #EF4444 !important;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="auth-container w-full max-w-md">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h1 class="auth-title">Criar uma conta</h1>
                <p class="auth-subtitle">Comece a gerenciar suas tarefas agora mesmo</p>
            </div>
            
            <div class="p-8">
                <form method="POST" action="{{ route('register.store') }}" id="registerForm">
                    @csrf

                    <div class="input-group">
                        <label for="nome_completo" class="input-label">Nome Completo</label>
                        <div class="relative">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" id="nome_completo" name="nome_completo" value="{{ old('nome_completo') }}"
                                   class="input-field @error('nome_completo') input-error @enderror"
                                   aria-describedby="nome_completo_error">
                        </div>
                        @error('nome_completo')
                            <p id="nome_completo_error" class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="email" class="input-label">Email</label>
                        <div class="relative">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   class="input-field @error('email') input-error @enderror"
                                   aria-describedby="email_error">
                        </div>
                        @error('email')
                            <p id="email_error" class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="password" class="input-label">Senha</label>
                        <div class="relative">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password" name="password"
                                   class="input-field @error('password') input-error @enderror"
                                   aria-describedby="password_error">
                            <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                        </div>
                        @error('password')
                            <p id="password_error" class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="password_confirmation" class="input-label">Confirmar Senha</label>
                        <div class="relative">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="input-field @error('password_confirmation') input-error @enderror"
                                   aria-describedby="password_confirmation_error">
                            <i class="fas fa-eye password-toggle" id="togglePasswordConfirmation"></i>
                        </div>
                        @error('password_confirmation')
                            <p id="password_confirmation_error" class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-user-plus mr-2"></i> Registrar
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Já tem uma conta? <a href="{{ route('login') }}" class="auth-link">Faça login</a></p>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any() && !$errors->has('nome_completo') && !$errors->has('email') && !$errors->has('password') && !$errors->has('password_confirmation'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro de Validação',
                html: `@foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach`,
                confirmButtonText: 'OK',
                background: 'white'
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000,
                background: 'white',
                position: 'top-end',
                toast: true
            });
        </script>
    @endif

    <script>
        // Toggle password visibility
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        
        const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
        const passwordConfirmation = document.querySelector('#password_confirmation');
        
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
        
        togglePasswordConfirmation.addEventListener('click', function() {
            const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmation.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
        
        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            let isValid = true;
            
            // Clear previous errors
            document.querySelectorAll('.input-error').forEach(el => {
                el.classList.remove('input-error');
            });
            
            document.querySelectorAll('.error-message').forEach(el => {
                if (!el.id.includes('js_')) el.textContent = '';
            });
            
            // Name validation
            const name = document.getElementById('nome_completo').value.trim();
            if (!name) {
                showError('nome_completo', 'O nome completo é obrigatório');
                isValid = false;
            } else if (name.length < 3) {
                showError('nome_completo', 'O nome deve ter pelo menos 3 caracteres');
                isValid = false;
            }
            
            // Email validation
            const email = document.getElementById('email').value.trim();
            if (!email) {
                showError('email', 'O email é obrigatório');
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                showError('email', 'Por favor, insira um email válido');
                isValid = false;
            }
            
            // Password validation
            const password = document.getElementById('password').value;
            if (!password) {
                showError('password', 'A senha é obrigatória');
                isValid = false;
            } else if (password.length < 6) {
                showError('password', 'A senha deve ter pelo menos 6 caracteres');
                isValid = false;
            }
            
            // Password confirmation
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            if (password !== passwordConfirmation) {
                showError('password_confirmation', 'As senhas não coincidem');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                
                // Scroll to first error
                const firstError = document.querySelector('.input-error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
        
        function showError(fieldId, message) {
            const field = document.getElementById(fieldId);
            field.classList.add('input-error');
            
            let errorElement = document.getElementById(`${fieldId}_error`);
            if (errorElement) {
                errorElement.textContent = message;
            }
        }
    </script>
</body>
</html>