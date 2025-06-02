// cypress/e2e/tasks.cy.js
describe('Fluxo de Tarefas e Multi-Tenancy', () => {
    const userA = {
        email: 'testedetask@gmail.com', // GARANTA QUE SEU UserSeeder CRIE ESTE USUÁRIO
        password: 'Senhadoteste123@'
    };
    const userB = {
        email: 'email.ja.existe@example.com', // GARANTA QUE SEU UserSeeder CRIE ESTE USUÁRIO
        password: 'Password123!'
    };
    const taskTitleUserA = `Tarefa de Teste UserA - ${Date.now()}`;


    it('deve permitir que UserA crie uma tarefa, e UserB não deve vê-la', () => {
        // 1. Login como UserA
        cy.visit('/login');
        cy.get('#email').type(userA.email);
        cy.get('#password').type(userA.password);
        cy.get('button[type="submit"]').click(); // Botão "Entrar"
        cy.url().should('include', '/tasks');
        cy.get('#swal2-title').should('contain.text', 'Sucesso!'); // Toast de login

        // 2. UserA Cria uma Tarefa
        cy.get('a[href*="/tasks/create"]').first().click(); // Botão "Criar tarefa" ou "Criar primeira tarefa"
        cy.url().should('include', '/tasks/create');

        cy.get('#title').type(taskTitleUserA);
        cy.get('#description').type('Esta é uma descrição da tarefa criada pelo UserA.');
        cy.get('#due_date').type('2025-07-15');
        cy.get('#priority').select('Media');
        cy.get('form#taskForm button[type="submit"]').click();

        // 3. Assert task creation success para UserA
        cy.url().should('include', '/tasks');
        cy.get('#swal2-title').should('contain.text', 'Sucesso!'); // Toast "Tarefa criada com sucesso!"
        cy.contains('.task-card h3', taskTitleUserA).should('be.visible'); // Verifica se a tarefa aparece na lista do UserA

        // 4. UserA Logs Out
        // O botão de logout está dentro de um form no seu index.blade.php
        cy.get('header form[action*="/logout"] button[type="submit"]').click();
        cy.url().should('include', '/login'); // Deve ser redirecionado para login
        cy.get('#swal2-title').should('contain.text', 'Sucesso!'); // Toast "Você foi desconectado"

        // 5. Login como UserB
        cy.get('#email').type(userB.email);
        cy.get('#password').type(userB.password);
        cy.get('button[type="submit"]').click();
        cy.url().should('include', '/tasks');
        cy.get('#swal2-title').should('contain.text', 'Sucesso!');

        // 6. UserB Verifica se a tarefa de UserA NÃO está visível
        cy.contains('.task-card h3', taskTitleUserA).should('not.exist');

        // Adicional: Verifica se a mensagem "Nenhuma tarefa encontrada" aparece para UserB
        // (se UserB não tiver nenhuma tarefa própria semeada)
        cy.get('.empty-state h3').should('contain.text', 'Nenhuma tarefa encontrada'); //
    });



});
