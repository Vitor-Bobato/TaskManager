describe('Formulário de Registro', () => {
    const testNomeCompleto = 'Test User Cypress';
    const testEmailUnico = `testuser_${Date.now()}@example.com`;
    const testPassword = 'Password123!';
    const emailPreCadastradoPeloSeeder = 'email.ja.existe@example.com';

    beforeEach(() => {
        cy.exec('php artisan migrate:fresh --seed --env=testing');
        cy.visit('/register');
    });

    it('Deve exibir erro para o nome completo vazio', () => {
        cy.get('button[type="submit"]').click();
        cy.get('#nome_completo_error').should('be.visible').and('contain.text', 'O nome completo é obrigatório');
    });

    it('Deve exibir erro para o nome completo menor que 3 caracteres', () => {
        cy.get('#nome_completo').type('Jo');
        cy.get('button[type="submit"]').click();
        cy.get('#nome_completo_error').should('be.visible').and('contain.text', 'O nome completo deve ter pelo menos 3 caracteres');
    });

    it('Deve exibir erro para o nome completo maior que 255 caracteres', () => {
        cy.get('#nome_completo').type('a'.repeat(256));
        cy.get('#email').type(`temp_${Date.now()}@example.com`);
        cy.get('#password').type(testPassword);
        cy.get('#password_confirmation').type(testPassword);
        cy.get('button[type="submit"]').click();
        // Espera que a página recarregue com o erro do backend
        cy.get('#nome_completo_error').should('be.visible').and('contain.text', 'O nome completo não pode exceder 255 caracteres');
    });

    it('Deve exibir erro para o email vazio', () => {
        cy.get('button[type="submit"]').click();
        cy.get('#email_error').should('be.visible').and('contain.text', 'O email é obrigatório');
    });

    it('Deve exibir erro para o email inválido', () => {
        cy.get('#email').type('invalid-email');
        cy.get('button[type="submit"]').click();
        cy.get('#email_error').should('be.visible').and('contain.text', 'Por favor, insira um email válido');
    });

    it('Deve exibir erro para o email já cadastrado', () => {
        cy.get('#nome_completo').type('Nome Qualquer');
        cy.get('#email').type(emailPreCadastradoPeloSeeder);
        cy.get('#password').type(testPassword);
        cy.get('#password_confirmation').type(testPassword);
        cy.get('button[type="submit"]').click();
        cy.get('#email_error').should('be.visible').and('contain.text', 'Este endereço de email já está cadastrado');
    });

    it('Deve exibir o erro para email com mais de 255 caracteres', () => {
        cy.get('#nome_completo').type('Nome Válido');
        cy.get('#email').type('a'.repeat(246) + '@example.com');
        cy.get('#password').type(testPassword);
        cy.get('#password_confirmation').type(testPassword);
        cy.get('button[type="submit"]').click();
        cy.get('#email_error').should('be.visible').and('contain.text', 'O email não pode exceder 255 caracteres');
    });

    it('Deve exibir erro para senha vazia', () => {
        cy.get('button[type="submit"]').click();
        cy.get('#password_error').should('be.visible').and('contain.text', 'A senha é obrigatória');
    });

    it('Deve exibir erro para senha menor que 8 caracteres', () => {
        cy.get('#password').type('Pass1!');
        cy.get('button[type="submit"]').click();
        cy.get('#password_error').should('be.visible').and('contain.text', 'A senha deve ter pelo menos 8 caracteres');
    });

    it('Deve exibir erro para senha sem letras maiúsculas', () => {
        cy.get('#password').type('password123!');
        cy.get('button[type="submit"]').click();
        cy.get('#password_error').should('be.visible').and('contain.text', 'A senha deve conter pelo menos uma letra maiúscula (A-Z)');
    });

    it('Deve exibir erro para senha sem letras minúsculas', () => {
        cy.get('#password').type('PASSWORD123!');
        cy.get('button[type="submit"]').click();
        cy.get('#password_error').should('be.visible').and('contain.text', 'A senha deve conter pelo menos uma letra minúscula (a-z)');
    });

    it('Deve exibir erro para senha sem números', () => {
        cy.get('#password').type('Password!');
        cy.get('button[type="submit"]').click();
        cy.get('#password_error').should('be.visible').and('contain.text', 'A senha deve conter pelo menos um número');
    });

    it('Deve exibir erro para senha sem caracter especial', () => {
        cy.get('#password').type ('Password123');
        cy.get('button[type="submit"]').click();
        cy.get('#password_error').should('be.visible').and('contain.text', 'A senha deve conter pelo menos um caractere especial (ex: !@#$%)');
    });

    it('Deve exibir erro para a confirmação de senha vazia', () => {
        cy.get('#password').type(testPassword);
        cy.get('button[type="submit"]').click();
        cy.get('#password_confirmation_error').should('be.visible').and('contain.text', 'A confirmação da senha é obrigatória');
    });

    it('Deve exibir erro se a confirmação de senha não coincidir', () => {
        cy.get('#password').type(testPassword);
        cy.get('#password_confirmation').type('DifferentPassword123!');
        cy.get('button[type="submit"]').click();
        cy.get('#password_confirmation_error').should('be.visible').and('contain.text', 'As senhas não coincidem');
    });


    it('Deve registrar o usuário com sucesso e redirecionar para Login', () => {
        cy.get('#nome_completo').type(testNomeCompleto);
        cy.get('#email').type(testEmailUnico);
        cy.get('#password').type(testPassword);
        cy.get('#password_confirmation').type(testPassword);
        cy.get('button[type="submit"]').click();

        cy.url().should('include', '/login');
        cy.get('#swal2-title', { timeout: 10000 }).should('contain.text', 'Sucesso!');
        cy.get('#swal2-html-container').should('contain.text', 'Usuário registrado com sucesso! Por favor, faça o login.');
    });
});
