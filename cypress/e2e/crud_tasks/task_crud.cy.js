// cypress/e2e/tasks_crud.cy.js

describe('Fluxo CRUD de Tarefas e Validações', () => {
    const userCredentials = {
        email: 'test@example.com',
        password: 'Password123!'
    };

    const initialTaskTitle = `Minha Tarefa de Teste - ${Date.now()}`;
    const initialTaskDescription = 'Descrição inicial da tarefa de teste.';
    const initialTaskDate = '2025-10-10';
    const initialTaskPriority = 'Alta';

    const updatedTaskTitle = `Tarefa Editada com Sucesso - ${Date.now()}`;
    const updatedTaskDescription = 'Esta é a descrição após a edição.';
    const updatedTaskDate = '2025-11-23';
    const updatedTaskPriority = 'Media';

    beforeEach(() => {
        cy.exec('php artisan migrate:fresh --seed --env=testing');

        cy.visit('/login');
        cy.get('#email').type(userCredentials.email);
        cy.get('#password').type(userCredentials.password);
        cy.get('form#loginForm button[type="submit"]').click();
        cy.url().should('include', '/tasks');
    });

    context('Validações do Formulário de Criação de Tarefa', () => {
        beforeEach(() => {
            cy.get('a[href*="/tasks/create"]').first().click();
            cy.url().should('include', '/tasks/create');
        });

        it('Deve exibir erro para título vazio', () => {
            cy.get('form#taskForm button[type="submit"]').click();
            cy.get('#js-error-title').should('be.visible').and('contain.text', 'O título é obrigatório');
        });

        it('Deve exibir erro para data no passado', () => {
            const yesterday = new Date();
            yesterday.setDate(yesterday.getDate() - 1);
            const yyyy = yesterday.getFullYear();
            const mm = String(yesterday.getMonth() + 1).padStart(2, '0');
            const dd = String(yesterday.getDate()).padStart(2, '0');
            const pastDate = `${yyyy}-${mm}-${dd}`;

            cy.get('#due_date').type(pastDate);
            cy.get('body').click();
            cy.get('form#taskForm button[type="submit"]').click();
            cy.get('#js-error-due_date').should('be.visible').and('contain.text', 'A data limite não pode ser anterior a hoje.');
        });
    });

    context('Fluxo Completo de CRUD de uma Tarefa', () => {
        it('Deve criar, validar, editar, concluir e excluir uma tarefa', () => {
            cy.get('a[href*="/tasks/create"]').first().click();
            cy.get('#title').type(initialTaskTitle);
            cy.get('#description').type(initialTaskDescription);
            cy.get('#due_date').type(initialTaskDate);
            cy.get('#priority').select(initialTaskPriority);
            cy.get('form#taskForm button[type="submit"]').click();

            cy.url().should('include', '/tasks');
            cy.get('#swal2-title', { timeout: 10000 }).should('contain.text', 'Sucesso!');
            cy.get('#swal2-html-container').should('contain.text', 'Tarefa criada com sucesso!');

            cy.contains('.task-card h3', initialTaskTitle)
                .should('be.visible')
                .parents('.task-card')
                .as('taskCard');

            cy.get('@taskCard').within(() => {
                cy.contains(initialTaskDescription).should('be.visible');
                cy.contains('10/10/2025').should('be.visible');
                cy.contains('Prioridade: Alta').should('be.visible');
            });

            cy.get('@taskCard').find('a[title="Editar"]').click();
            cy.url().should('include', '/edit');

            cy.get('#title').clear().type(updatedTaskTitle);
            cy.get('#description').clear().type(updatedTaskDescription);
            cy.get('#due_date').type(updatedTaskDate);
            cy.get('#priority').select(updatedTaskPriority);
            cy.get('form#taskForm button[type="submit"]').click();

            cy.url().should('include', '/tasks');
            cy.get('#swal2-title').should('contain.text', 'Sucesso!');
            cy.get('#swal2-html-container').should('contain.text', 'Tarefa atualizada com sucesso!');

            cy.contains('.task-card h3', updatedTaskTitle)
                .should('be.visible')
                .parents('.task-card')
                .as('updatedTaskCard');

            cy.get('@updatedTaskCard').within(() => {
                cy.contains(updatedTaskDescription).should('be.visible');
                cy.contains('23/11/2025').should('be.visible');
                cy.contains('Prioridade: Media').should('be.visible');
            });

            cy.get('@updatedTaskCard').find('.complete-btn').as('completeButton');
            cy.get('@completeButton').click();

            cy.get('@completeButton').should('contain.text', 'Reabrir').and('have.class', 'bg-blue-600');
            cy.get('@updatedTaskCard').find('.task-complete').should('have.class', 'completed');
            cy.get('@completeButton').click();
            cy.get('@completeButton').should('contain.text', 'Concluir').and('have.class', 'bg-green-600');

            cy.get('@updatedTaskCard').find('button[title="Excluir"]').click();

            cy.get('.swal2-confirm').contains('Sim, excluir!').click();

            cy.url().should('include', '/tasks');
            cy.get('#swal2-title').should('contain.text', 'Sucesso!');
            cy.get('#swal2-html-container').should('contain.text', 'Tarefa excluída com sucesso!');

            cy.contains('.task-card h3', updatedTaskTitle).should('not.exist');
            cy.get('.empty-state').should('be.visible').and('contain.text', 'Nenhuma tarefa encontrada');
        });
    });
});
