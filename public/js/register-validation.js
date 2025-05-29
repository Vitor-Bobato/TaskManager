document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');

    if (form) {
        // Configura validações
        form.addEventListener('submit', handleSubmit);
        setupLiveValidation();
    }
});

// Objeto de regras de validação
const validationRules = {
    nome_completo: {
        required: true,
        minLength: 3,
        messages: {
            required: 'O nome completo é obrigatório',
            minLength: 'O nome deve ter pelo menos 3 caracteres'
        }
    },
    email: {
        required: true,
        pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        messages: {
            required: 'O email é obrigatório',
            pattern: 'Digite um email válido'
        }
    },
    password: {
        required: true,
        minLength: 8,
        messages: {
            required: 'A senha é obrigatória',
            minLength: 'A senha deve ter no mínimo 8 caracteres'
        }
    },
    password_confirmation: {
        required: true,
        matches: 'password',
        messages: {
            required: 'A confirmação de senha é obrigatória',
            matches: 'As senhas não coincidem'
        }
    }
};

function handleSubmit(e) {
    e.preventDefault();
    clearAllErrors();

    const errors = validateForm();

    if (errors.length > 0) {
        showFormErrors(errors);
    } else {
        this.submit();
    }
}

function validateForm() {
    let errors = [];

    for (const [fieldId, rules] of Object.entries(validationRules)) {
        const input = document.getElementById(fieldId);
        let value = input.value; // Não use trim() aqui para senhas, pois espaços podem ser intencionais

        if (rules.required && !value && input.type !== 'password') { // Para senhas, não trimar
            value = input.value.trim();
        }


        // Validação de campo obrigatório
        if (rules.required && !value) {
            errors.push(rules.messages.required);
            markFieldAsInvalid(fieldId, rules.messages.required);
            continue; // Pula para o próximo campo
        }

        // Validação de tamanho mínimo (não se aplica à confirmação de senha diretamente, mas ao campo original)
        if (rules.minLength && value.length < rules.minLength) {
            errors.push(rules.messages.minLength);
            markFieldAsInvalid(fieldId, rules.messages.minLength);
            continue;
        }

        // Validação por regex (email)
        if (rules.pattern && !rules.pattern.test(value)) {
            errors.push(rules.messages.pattern);
            markFieldAsInvalid(fieldId, rules.messages.pattern);
            continue;
        }

        // Validação de correspondência (para confirmação de senha)
        if (rules.matches) {
            const otherField = document.getElementById(rules.matches);
            if (value !== otherField.value) {
                errors.push(rules.messages.matches);
                markFieldAsInvalid(fieldId, rules.messages.matches);
                // Opcionalmente, marque o campo original também se desejar
                // markFieldAsInvalid(otherField.id, rules.messages.matches, false);
            }
        }
    }
    return errors;
}

// Configura validação em tempo real
function setupLiveValidation() {
    for (const fieldId in validationRules) {
        const input = document.getElementById(fieldId);

        input.addEventListener('blur', function() {
            validateSingleField(fieldId);
        });

        input.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                validateSingleField(fieldId);
            } else {
                clearFieldError(fieldId);
            }
        });
    }
}

// Valida um campo específico
function validateSingleField(fieldId) {
    const rules = validationRules[fieldId];
    const input = document.getElementById(fieldId);
    let value = input.value; // Não trimar senhas inicialmente

    if (input.type !== 'password') {
        value = input.value.trim();
    }


    clearFieldError(fieldId); // Limpa erros anteriores do campo atual

    let isValid = true;

    if (rules.required && !value) {
        markFieldAsInvalid(fieldId, rules.messages.required, false);
        isValid = false;
    } else if (rules.minLength && value.length < rules.minLength) {
        markFieldAsInvalid(fieldId, rules.messages.minLength, false);
        isValid = false;
    } else if (rules.pattern && !rules.pattern.test(value)) {
        markFieldAsInvalid(fieldId, rules.messages.pattern, false);
        isValid = false;
    } else if (rules.matches) {
        const otherField = document.getElementById(rules.matches);
        if (value !== otherField.value) {
            markFieldAsInvalid(fieldId, rules.messages.matches, false);
            isValid = false;
        }
    }

    if (isValid && value) { // Marca como válido apenas se passou em todas as validações e não está vazio
        input.classList.add('border-green-500');
    } else if (!value && !rules.required) { // Se o campo não é obrigatório e está vazio, não deve ser vermelho
        clearFieldError(fieldId); // Garante que não fique vermelho se não for obrigatório e estiver vazio
        input.classList.remove('border-green-500'); // Remove o verde se estava e foi apagado
    }


    // Se o campo atual é 'password' e tem um campo de confirmação, revalide a confirmação
    if (fieldId === 'password') {
        const confirmationFieldId = Object.keys(validationRules).find(
            key => validationRules[key].matches === 'password'
        );
        if (confirmationFieldId) {
            const confirmationInput = document.getElementById(confirmationFieldId);
            if (confirmationInput.value) { // Só revalida se já tiver algo digitado na confirmação
                validateSingleField(confirmationFieldId);
            }
        }
    }
    // Se o campo atual é o de confirmação e o campo de senha principal tem valor, revalide a senha principal (menos comum, mas pode ser útil)
    else if (rules.matches) { // Se o campo atual é um campo de "matches"
        const mainField = document.getElementById(rules.matches);
        if (mainField.value && validationRules[mainField.id]) { // Se o campo principal tem valor e regras
            // Não é comum revalidar o campo original aqui, mas se precisar, chame validateSingleField(mainField.id)
            // Apenas garantimos que se o campo principal estiver válido e a confirmação mudar para válido, ambos fiquem verdes.
            // Se a confirmação ficar inválida, só ela fica vermelha.
        }
    }


    return isValid;
}

// Funções auxiliares
function clearAllErrors() {
    document.querySelectorAll('.error-message').forEach(el => el.remove());
    document.querySelectorAll('input').forEach(input => {
        input.classList.remove('border-red-500', 'border-green-500');
    });
}

function clearFieldError(fieldId) {
    const input = document.getElementById(fieldId);
    input.classList.remove('border-red-500');
    const errorMsg = input.parentNode.querySelector('.error-message');
    if (errorMsg) errorMsg.remove();
}

function markFieldAsInvalid(fieldId, message, showInAlert = true) {
    const input = document.getElementById(fieldId);
    input.classList.remove('border-green-500');
    input.classList.add('border-red-500');

    // Evita duplicar mensagens
    if (!input.parentNode.querySelector('.error-message')) {
        const errorMsg = document.createElement('p');
        errorMsg.className = 'error-message text-sm text-red-600 mt-1';
        errorMsg.textContent = message;
        input.parentNode.appendChild(errorMsg);
    }
}

function showFormErrors(errors) {
    Swal.fire({
        icon: 'error',
        title: 'Erro no formulário',
        html: errors.map(err => `• ${err}`).join('<br>'),
        confirmButtonText: 'Entendi'
    });
}
