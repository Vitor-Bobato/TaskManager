// cypress/e2e/auth/registration_spec.cy.js

describe('Formulário de Registro - Testes Abrangentes', () => {
    beforeEach(() => {
        // Visita a página de registro antes de cada teste neste bloco
        cy.visit('/register'); // Certifique-se que '/register' é a rota correta
    });

    it('deve impedir o registro e mostrar erros de backend (inline e SweetAlert) se campos excederem o limite máximo', () => {
        const longString = 'a'.repeat(300); // String > 255 caracteres
        const validPassword = 'senhaValida123';

        cy.get('#nome_completo').type(longString, { delay: 0 });
        cy.get('#email').type(`${longString}@exemplo.com`, { delay: 0 });
        cy.get('#password').type(validPassword, { delay: 0 });
        cy.get('#password_confirmation').type(validPassword, { delay: 0 });

        cy.get('button[type="submit"]').contains('Registrar').click();

        // 1. Verificar se a URL permanece na página de registro
        cy.url().should('include', '/register');

        cy.get('#nome_completo_error')
            .should('be.visible')
            .and('contain.text', 'O nome completo não pode exceder 255 caracteres');

        cy.get('#email_error')
            .should('be.visible')
            .and('contain.text', 'O email não pode exceder 255 caracteres');

        cy.get('.swal2-popup').should('be.visible'); // Verifica se o popup do SweetAlert está visível
        cy.get('.swal2-title').should('contain.text', 'Por favor, corrija os erros:'); // Ou o título que você usa

        // Verifica se as mensagens específicas estão no corpo do SweetAlert
        // O SweetAlert renderiza o HTML, então podemos verificar o conteúdo do container.
        cy.get('.swal2-html-container')
            .should('contain.text', 'O nome completo não pode exceder 255 caracteres')
            .and('contain.text', 'O email não pode exceder 255 caracteres');

        // Fecha o SweetAlert para continuar, se necessário, ou para limpar a UI para o próximo teste
        cy.get('button.swal2-confirm').click();
        cy.get('.swal2-popup').should('not.exist'); // Confirma que o popup fechou

    });

    it('deve mostrar erros de validação do JavaScript (inline) se implementado, antes do envio ao backend', () => {
        const longStringForJSValidation = 'b'.repeat(260); // Apenas um pouco acima do limite para JS

        // Testando validação JS para nome_completo
        cy.get('#nome_completo').type(longStringForJSValidation, { delay: 0 });
        cy.get('#nome_completo').blur(); // Aciona a validação 'onblur' do seu register-validation.js

        // Verifique a mensagem de erro específica do seu JavaScript
        cy.get('#nome_completo_error')
            .should('be.visible')
            .and('contain.text', 'O nome completo não pode exceder 255 caracteres.'); // Exemplo de mensagem JS

        // Testando validação JS para email
        cy.get('#email').type(`${longStringForJSValidation}@exemplo.com`, { delay: 0 });
        cy.get('#email').blur();

        cy.get('#email_error')
            .should('be.visible')
            .and('contain.text', 'O email não pode exceder 255 caracteres'); // Exemplo de mensagem JS

        // Tenta submeter o formulário mesmo com erros de JS (para ver se o JS impede ou se o backend pega)
        cy.get('#password').type('senhaValida123', { delay: 0 });
        cy.get('#password_confirmation').type('senhaValida123', { delay: 0 });
        cy.get('button[type="submit"]').contains('Registrar').click();

        cy.url().should('include', '/register');

        cy.get('#nome_completo_error').should('be.visible'); // Confirma que o erro (JS ou Backend) ainda está lá
        cy.get('#email_error').should('be.visible');
    });
});
