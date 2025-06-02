<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TaskManager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #10B981;
            --primary-dark: #047857;
            --primary-light: #D1FAE5;
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
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
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

        .btn-submit.loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            z-index: 1;
        }

        .btn-submit.loading::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            z-index: 2;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .remember-me input {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="auth-container w-full max-w-md">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <h1 class="auth-title">Bem-vindo de volta</h1>
                <p class="auth-subtitle">Faça login para acessar suas tarefas</p>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('login.store') }}" id="loginForm">
                    @csrf

                    <div class="input-group">
                        <label for="email" class="input-label">Email</label>
                        <div class="relative">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   maxlength="256"  autocomplete="off"
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


                    <button type="submit" class="btn-submit" id="submitButton">
                        <i class="fas fa-sign-in-alt mr-2"></i> Entrar
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Não tem uma conta? <a href="{{ route('register') }}" class="auth-link">Registre-se</a></p>
                </div>
            </div>
        </div>
    </div>

    @if (session('error_login'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro no Login',
                text: '{{ session('error_login') }}',
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

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Form submission with loading state
        const loginForm = document.getElementById('loginForm');
        const submitButton = document.getElementById('submitButton');

        loginForm.addEventListener('submit', function(e) {
            let isValid = true;

            // Clear previous errors
            document.querySelectorAll('.input-field').forEach(el => {
                el.classList.remove('input-error');
            });

            document.querySelectorAll('.p.error-message').forEach(el => {
                el.remove();
            });

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
            }

            if (!isValid) {
                e.preventDefault();

                // Scroll to first error
                const firstError = document.querySelector('.input-error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            } else {
                // Show loading state
                submitButton.classList.add('loading');
                submitButton.innerHTML = '';
                submitButton.setAttribute('disabled', 'disabled');
            }
        });

        function showError(fieldId, message) {
            const field = document.getElementById(fieldId);
            if (!field) {
                console.error('Campo não encontrado para showError:', fieldId);
                return;
            }

            field.classList.add('input-error'); // Adiciona a borda vermelha (isso já está funcionando)

            // Tenta encontrar o elemento de erro. Se não existir, cria um.
            let errorElement = document.getElementById(`${fieldId}_error`);

            if (!errorElement) {
                errorElement = document.createElement('p');
                errorElement.id = `${fieldId}_error`; // Mantém o padrão de ID para consistência
                errorElement.className = 'error-message'; // Classe para estilização

                // Insere o elemento de erro após o div 'relative' que contém o input.
                // A estrutura no seu HTML é:
                // <div class="input-group">
                //   <label ...></label>
                //   <div class="relative"> <input id="fieldId" ...> </div>
                //   //   // </div>
                let inputWrapper = field.parentElement; //  O <div class="relative">
                if (inputWrapper && inputWrapper.classList.contains('relative')) {
                    inputWrapper.parentElement.appendChild(errorElement); // Adiciona ao <div class="input-group">
                } else {
                    // Fallback se a estrutura for diferente: insere após o próprio campo
                    field.parentNode.insertBefore(errorElement, field.nextSibling);
                }
            }

            errorElement.textContent = message;
            errorElement.style.display = 'block'; // Garante que esteja visível
        }

        // Auto-focus email field if empty, otherwise password
        document.addEventListener('DOMContentLoaded', function() {
            const emailField = document.getElementById('email');
            const passwordField = document.getElementById('password');

            if (emailField.value === '') {
                emailField.focus();
            } else {
                passwordField.focus();
            }
        });
    </script>
</body>
</html>
