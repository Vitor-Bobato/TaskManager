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
                        <label for="text" class="input-label">Email</label>
                        <div class="relative">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="text" id="email" name="email" value="{{ old('email') }}"
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
        // Toggle password visibility (SEU CÓDIGO ORIGINAL - MANTIDO)
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInputEl = document.querySelector('#password'); // Renomeado para clareza
        const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
        const passwordConfirmationInputEl = document.querySelector('#password_confirmation'); // Renomeado

        if (togglePassword && passwordInputEl) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInputEl.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInputEl.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }

        if (togglePasswordConfirmation && passwordConfirmationInputEl) {
            togglePasswordConfirmation.addEventListener('click', function() {
                const type = passwordConfirmationInputEl.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmationInputEl.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }

        // Função showError ATUALIZADA para criar o elemento de erro se não existir
        function showError(fieldId, message) {
            const field = document.getElementById(fieldId);
            if (!field) {
                console.error('Campo não encontrado para showError:', fieldId);
                return;
            }
            field.classList.add('input-error');
            let errorElement = document.getElementById(`${fieldId}_error`); // Usa _error
            if (!errorElement) {
                errorElement = document.createElement('p');
                errorElement.id = `${fieldId}_error`; // Usa _error
                errorElement.className = 'error-message';
                let inputWrapper = field.parentElement;
                if (inputWrapper && inputWrapper.classList.contains('relative')) {
                    if (inputWrapper.parentElement && inputWrapper.parentElement.classList.contains('input-group')) {
                        inputWrapper.parentElement.appendChild(errorElement);
                    } else {
                        inputWrapper.appendChild(errorElement);
                    }
                } else {
                    field.parentNode.insertBefore(errorElement, field.nextSibling);
                }
            }
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }

        // Form validation
        if (document.getElementById('registerForm')) {
            document.getElementById('registerForm').addEventListener('submit', function(e) {
                // Limpar classes de erro dos inputs
                document.querySelectorAll('.input-field').forEach(el => {
                    el.classList.remove('input-error');
                });
                // Limpar mensagens de erro (removendo os elementos <p>)
                document.querySelectorAll('p.error-message').forEach(el => {
                    el.remove();
                });

                let isValid = true;
                let specificErrorMessages = []; // Para o SweetAlert (se você decidir reativá-lo)

                function processFieldValidation(fieldId, condition, errorMessage) {
                    if (condition) {
                        showError(fieldId, errorMessage);
                        if (!specificErrorMessages.includes(errorMessage)) {
                            specificErrorMessages.push(errorMessage);
                        }
                        isValid = false;
                    }
                }

                // Name validation
                const name = document.getElementById('nome_completo').value.trim();
                processFieldValidation('nome_completo', !name, 'O nome completo é obrigatório');
                if (name) { // Só checa min se o nome não estiver vazio
                    processFieldValidation('nome_completo', name.length < 3, 'O nome completo deve ter pelo menos 3 caracteres');
                }
                // Validação de MAX length para nome (client-side opcional, backend já tem)
                // if (name.length > 255) { processFieldValidation('nome_completo', true, 'O nome completo não pode exceder 255 caracteres.');}


                // Email validation
                const email = document.getElementById('email').value.trim();
                processFieldValidation('email', !email, 'O email é obrigatório');
                if (email) { // Só checa formato se o email não estiver vazio
                    processFieldValidation('email', !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email), 'Por favor, insira um email válido');
                }
                // Validação de MAX length para email (client-side opcional, backend já tem)
                // if (email.length > 255) { processFieldValidation('email', true, 'O email não pode exceder 255 caracteres.');}

                // Password validation (com todas as regras de complexidade)
                const passwordValue = passwordInputEl.value; // Usa a variável do escopo externo
                const passwordErrorFieldId = 'password';
                processFieldValidation(passwordErrorFieldId, !passwordValue, 'A senha é obrigatória');
                if (passwordValue) {
                    // Para o SweetAlert listar todos os erros de senha, cada um seria um 'if' separado.
                    // Para inline, showError sobrescreve, então a primeira mensagem de erro é a que fica.
                    // Vamos manter a lógica de "primeiro erro encontrado" para o inline, que o else if faz.
                    if (passwordValue.length < 8) {
                        processFieldValidation(passwordErrorFieldId, true, 'A senha deve ter pelo menos 8 caracteres');
                    } else if (!/[A-Z]/.test(passwordValue)) {
                        processFieldValidation(passwordErrorFieldId, true, 'A senha deve conter pelo menos uma letra maiúscula (A-Z)');
                    } else if (!/[a-z]/.test(passwordValue)) {
                        processFieldValidation(passwordErrorFieldId, true, 'A senha deve conter pelo menos uma letra minúscula (a-z)');
                    } else if (!/\d/.test(passwordValue)) {
                        processFieldValidation(passwordErrorFieldId, true, 'A senha deve conter pelo menos um número (0-9)');
                    } else if (!/[!@#$%^&*(),.?":{}|<>]/.test(passwordValue)) {
                        processFieldValidation(passwordErrorFieldId, true, 'A senha deve conter pelo menos um caractere especial (ex: !@#$%)');
                    }
                }

                // Password Confirmation validation
                const passwordConfirmationValue = passwordConfirmationInputEl.value; // Usa a variável do escopo externo
                if (passwordValue) { // Só valida confirmação se a senha principal foi digitada
                    processFieldValidation('password_confirmation', !passwordConfirmationValue, 'A confirmação da senha é obrigatória.'); // << CORRIGIDO para mensagem correta
                    if (passwordConfirmationValue) { // Só checa se são diferentes se a confirmação foi preenchida
                        processFieldValidation('password_confirmation', passwordValue !== passwordConfirmationValue, 'As senhas não coincidem');
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                    const firstErrorField = document.querySelector('.input-error');
                    if (firstErrorField) {
                        let elementToScrollTo = document.getElementById(`${firstErrorField.id}_error`) || firstErrorField;
                        if(elementToScrollTo) elementToScrollTo.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    // Se você quiser o SweetAlert com a lista de erros, descomente o bloco abaixo
                    /*
                    let sweetAlertContentHtml = 'Por favor, corrija os seguintes erros:<br><ul style="text-align: left; margin-top: 10px; list-style-position: inside; padding-left: 20px;">';
                    if (specificErrorMessages.length > 0) {
                        specificErrorMessages.forEach(msg => {
                            sweetAlertContentHtml += `<li>${msg}</li>`;
                        });
                        sweetAlertContentHtml += '</ul>';
                    } else {
                        sweetAlertContentHtml = 'Por favor, corrija os erros indicados no formulário.';
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Formulário Inválido!',
                        html: sweetAlertContentHtml,
                        confirmButtonText: 'OK',
                        confirmButtonColor: 'var(--primary)',
                        background: 'white'
                    });
                    */
                }
            });
        }
    </script>
</body>
</html>
