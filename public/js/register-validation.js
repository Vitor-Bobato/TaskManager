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
        maxLength: 255, // ADICIONADO: Regra de comprimento máximo
        messages: {
            required: 'O nome completo é obrigatório.',
            minLength: 'O nome deve ter pelo menos 3 caracteres.',
            maxLength: 'O nome completo não pode exceder 255 caracteres.' // ADICIONADO: Mensagem
        }
    },
    email: {
        required: true,
        pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        maxLength: 255, // ADICIONADO: Regra de comprimento máximo
        messages: {
            required: 'O email é obrigatório.',
            pattern: 'Digite um endereço de email válido (ex: usuario@dominio.com).',
            maxLength: 'O email não pode exceder 255 caracteres.' // ADICIONADO: Mensagem
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
    // Limpa todos os erros inline ANTES de validar o formulário novamente.
    // Isso é importante para que as mensagens de erro não se acumulem visualmente
    // se o usuário submeter várias vezes.
    // A função validateForm() chamará markFieldAsInvalid para os erros atuais.
    const errorMessagesPs = document.querySelectorAll('p.error-message');
    errorMessagesPs.forEach(p => p.textContent = ''); // Limpa o texto em vez de remover o elemento

    // Remove as classes de borda de erro/sucesso dos inputs
    document.querySelectorAll('input.border-red-500, input.border-green-500').forEach(input => {
        input.classList.remove('border-red-500', 'border-green-500');
    });


    const errors = validateForm(); // Esta função agora só retorna a lista de erros

    if (errors.length > 0) {
        e.preventDefault(); // Impede o envio do formulário se houver erros
        // markFieldAsInvalid já foi chamado por validateForm e validateSingleField
        // para exibir erros inline. O SweetAlert é um resumo adicional.
        showFormErrors(errors);
    } else {
        // Nenhuma ação de e.preventDefault(), permite o envio do formulário
        // O form.submit() não é necessário aqui se não houver preventDefault
    }
}


function validateForm() {
    let errors = [];

    for (const [fieldId, rules] of Object.entries(validationRules)) {
        const input = document.getElementById(fieldId);
        if (!input) continue;

        // validateSingleField agora retorna true se válido, false se inválido,
        // e também lida com a exibição da mensagem inline.
        if (!validateSingleField(fieldId)) {
            // Monta a mensagem de erro para o SweetAlert
            const value = input.type === 'password' ? input.value : input.value.trim();
            if (rules.required && !value) {
                errors.push(rules.messages.required);
            } else if (rules.minLength && value.length < rules.minLength) {
                errors.push(rules.messages.minLength);
            } else if (rules.maxLength && value.length > rules.maxLength) { // ADICIONADO
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
                clearFieldError(fieldId); // Limpa se não for obrigatório e estiver vazio
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

    clearFieldError(fieldId); // Limpa erros e classes do campo atual

    if (rules.required && !value) {
        errorMessageText = rules.messages.required;
    } else if (value) { // Só valida outras regras se houver valor ou se for obrigatório (já tratado acima)
        if (rules.minLength && value.length < rules.minLength) {
            errorMessageText = rules.messages.minLength;
        } else if (rules.maxLength && value.length > rules.maxLength) { // ADICIONADO
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
        return false; // Inválido
    } else {
        if (value) { // Marca como verde apenas se tiver conteúdo e passou nas validações
            input.classList.add('border-green-500');
        }
        // Se value for vazio mas não obrigatório, clearFieldError já limpou, não precisa de borda verde.
        return true; // Válido
    }
}

// Funções auxiliares MODIFICADAS
function clearAllErrors() {
    // Esta função agora é mais focada na limpeza visual para o handleSubmit,
    // pois clearFieldError e markFieldAsInvalid cuidam da limpeza e exibição individual.
    // No handleSubmit, já limpamos os error messages e bordas.
    // Esta função pode ser removida ou simplificada se o handleSubmit já fizer a limpeza.
    // Por hora, vamos manter a lógica de limpar p.error-message do handleSubmit.
}

function clearFieldError(fieldId) {
    const input = document.getElementById(fieldId);
    if (!input) return;
    input.classList.remove('border-red-500', 'border-green-500');

    // Seleciona o elemento <p> de erro pelo ID e limpa seu conteúdo
    const errorElement = document.getElementById(`${fieldId}_error`);
    if (errorElement) {
        errorElement.textContent = ''; // Limpa a mensagem de erro
    }
}

function markFieldAsInvalid(fieldId, message) {
    const input = document.getElementById(fieldId);
    if (!input) return;

    input.classList.remove('border-green-500');
    input.classList.add('border-red-500');
    input.setAttribute('aria-invalid', 'true');

    // Seleciona o elemento <p> de erro pelo ID e define sua mensagem
    const errorElement = document.getElementById(`${fieldId}_error`);
    if (errorElement) {
        errorElement.textContent = message;
    }
}

function showFormErrors(errors) {
    if (errors.length === 0) return; // Não mostra SweetAlert se não houver erros (já tratados inline)

    // Foca no primeiro campo com erro (melhora a acessibilidade)
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
