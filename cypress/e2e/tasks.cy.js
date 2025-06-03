// cypress/e2e/tasks.cy.js
describe('Fluxo de Tarefas e Multi-Tenancy', () => {
    const userA = {
        email: 'testedetask@gmail.com',
        password: 'Senhadoteste123@'
    };
    const userB = {
        email: 'email.ja.existe@example.com',
        password: 'Password123!'
    };
    const taskTitleUserA = `Tarefa de Teste UserA - ${Date.now()}`;


    it('deve permitir que UserA crie uma tarefa, e UserB não deve vê-la', () => {
        // 1. Login como UserA
        cy.visit('/login');
        cy.get('#email').type(userA.email);
        cy.get('#password').type(userA.password);
        cy.get('button[type="submit"]').click();
        cy.url().should('include', '/tasks');
        cy.get('#swal2-title').should('contain.text', 'Sucesso!');

        cy.get('a[href*="/tasks/create"]').first().click();
        cy.url().should('include', '/tasks/create');

        cy.get('#title').type(taskTitleUserA);
        cy.get('#description').type('Esta é uma descrição da tarefa criada pelo UserA.');
        cy.get('#due_date').type('2025-07-15');
        cy.get('#priority').select('Media');
        cy.get('form#taskForm button[type="submit"]').click();

        // 3. Assert task creation success para UserA
        cy.url().should('include', '/tasks');
        cy.get('#swal2-title').should('contain.text', 'Sucesso!');
        cy.contains('.task-card h3', taskTitleUserA).should('be.visible');

        cy.get('header form[action*="/logout"] button[type="submit"]').click();
        cy.url().should('include', '/login');
        cy.get('#swal2-title').should('contain.text', 'Sucesso!');

        cy.get('#email').type(userB.email);
        cy.get('#password').type(userB.password);
        cy.get('button[type="submit"]').click();
        cy.url().should('include', '/tasks');
        cy.get('#swal2-title').should('contain.text', 'Sucesso!');

        cy.contains('.task-card h3', taskTitleUserA).should('not.exist');

        cy.get('.empty-state h3').should('contain.text', 'Nenhuma tarefa encontrada'); //
    });

});
