document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');

    if (form) {
        setupLiveValidation();
        form.addEventListener('submit', handleSubmit);
    }
});

const validationRules = {
    nome_completo: {
        required: true,
        minLength: 3,
        maxLength: 255,
        messages: {
            required: 'O nome completo é obrigatório.',
            minLength: 'O nome deve ter pelo menos 3 caracteres.',
            maxLength: 'O nome completo não pode exceder 255 caracteres.'
        }
    },
    email: {
        required: true,
        pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        maxLength: 255, // ADICIONADO: Regra de comprimento máximo
        messages: {
            required: 'O email é obrigatório.',
            pattern: 'Digite um endereço de email válido (ex: usuario@dominio.com).',
            maxLength: 'O email não pode exceder 255 caracteres.'
        }
    },
    password: {
        required: true,
        minLength: 8,
        messages: {
            required: 'A senha é obrigatória.',
            minLength: 'A senha deve ter no mínimo 8 caracteres.'
        }
    },
    password_confirmation: {
        required: true,
        matches: 'password',
        messages: {
            required: 'A confirmação da senha é obrigatória.',
            matches: 'As senhas não coincidem.'
        }
    }
};

function handleSubmit(e) {
    const errorMessagesPs = document.querySelectorAll('p.error-message');
    errorMessagesPs.forEach(p => p.textContent = '');

    document.querySelectorAll('input.border-red-500, input.border-green-500').forEach(input => {
        input.classList.remove('border-red-500', 'border-green-500');
    });


    const errors = validateForm();

    if (errors.length > 0) {
        e.preventDefault();
        showFormErrors(errors);
    } else {
    }
}


function validateForm() {
    let errors = [];

    for (const [fieldId, rules] of Object.entries(validationRules)) {
        const input = document.getElementById(fieldId);
        if (!input) continue;

        if (!validateSingleField(fieldId)) {
            const value = input.type === 'password' ? input.value : input.value.trim();
            if (rules.required && !value) {
                errors.push(rules.messages.required);
            } else if (rules.minLength && value.length < rules.minLength) {
                errors.push(rules.messages.minLength);
            } else if (rules.maxLength && value.length > rules.maxLength) {
                errors.push(rules.messages.maxLength);
            } else if (rules.pattern && !rules.pattern.test(value)) {
                errors.push(rules.messages.pattern);
            } else if (rules.matches) {
                const otherField = document.getElementById(rules.matches);
                if (value !== otherField.value) {
                    errors.push(rules.messages.matches);
                }
            }
        }
    }
    return errors;
}

function setupLiveValidation() {
    for (const fieldId in validationRules) {
        const input = document.getElementById(fieldId);
        if (!input) continue;

        input.addEventListener('blur', function() {
            validateSingleField(fieldId);
        });

        input.addEventListener('input', function() {
            const rules = validationRules[fieldId];
            const value = this.type === 'password' ? this.value : this.value.trim();

            if (value !== '' || rules.required) {
                validateSingleField(fieldId);
            } else {
                clearFieldError(fieldId);
            }

            if (fieldId === 'password') {
                const confirmationInput = document.getElementById('password_confirmation');
                if (confirmationInput && confirmationInput.value !== '') {
                    validateSingleField('password_confirmation');
                }
            }
        });
    }
}

function validateSingleField(fieldId) {
    const rules = validationRules[fieldId];
    const input = document.getElementById(fieldId);
    if (!input || !rules) return true;

    const value = input.type === 'password' ? input.value : input.value.trim();
    let errorMessageText = '';

    clearFieldError(fieldId);

    if (rules.required && !value) {
        errorMessageText = rules.messages.required;
    } else if (value) {
        if (rules.minLength && value.length < rules.minLength) {
            errorMessageText = rules.messages.minLength;
        } else if (rules.maxLength && value.length > rules.maxLength) {
            errorMessageText = rules.messages.maxLength;
        } else if (rules.pattern && !rules.pattern.test(value)) {
            errorMessageText = rules.messages.pattern;
        } else if (rules.matches) {
            const otherFieldValue = document.getElementById(rules.matches)?.value;
            if (value !== otherFieldValue) {
                errorMessageText = rules.messages.matches;
            }
        }
    }

    if (errorMessageText) {
        markFieldAsInvalid(fieldId, errorMessageText);
        return false;
    } else {
        if (value) {
            input.classList.add('border-green-500');
        }
        return true;
    }
}

// Funções auxiliares MODIFICADAS
function clearAllErrors() {
}

function clearFieldError(fieldId) {
    const input = document.getElementById(fieldId);
    if (!input) return;
    input.classList.remove('border-red-500', 'border-green-500');

    const errorElement = document.getElementById(`${fieldId}_error`);
    if (errorElement) {
        errorElement.textContent = '';
    }
}

function markFieldAsInvalid(fieldId, message) {
    const input = document.getElementById(fieldId);
    if (!input) return;

    input.classList.remove('border-green-500');
    input.classList.add('border-red-500');
    input.setAttribute('aria-invalid', 'true');

    const errorElement = document.getElementById(`${fieldId}_error`);
    if (errorElement) {
        errorElement.textContent = message;
    }
}

function showFormErrors(errors) {
    if (errors.length === 0) return;

    const firstInvalidFieldId = Object.keys(validationRules).find(id => {
        const input = document.getElementById(id);
        return input && input.classList.contains('border-red-500');
    });
    if (firstInvalidFieldId) {
        document.getElementById(firstInvalidFieldId)?.focus();
    }

    Swal.fire({
        icon: 'error',
        title: 'Por favor, corrija os erros:',
        html: errors.map(err => `<p class="text-left">${err}</p>`).join(''),
        confirmButtonText: 'Entendi',
        customClass: {
            htmlContainer: 'text-left text-sm py-2'
        }
    });
}
