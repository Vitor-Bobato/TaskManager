// cypress/e2e/tasks_crud.cy.js

describe('Fluxo CRUD de Tarefas e Validações', () => {
    // Credenciais do usuário de teste que será criado pelo seeder
    const userCredentials = {
        email: 'test@example.com',
        password: 'Password123!'
    };

    // Dados para a tarefa que será criada e manipulada
    const initialTaskTitle = `Minha Tarefa de Teste - ${Date.now()}`;
    const initialTaskDescription = 'Descrição inicial da tarefa de teste.';
    const initialTaskDate = '2025-10-10'; // Formato YYYY-MM-DD para o input
    const initialTaskPriority = 'Alta';

    const updatedTaskTitle = `Tarefa Editada com Sucesso - ${Date.now()}`;
    const updatedTaskDescription = 'Esta é a descrição após a edição.';
    const updatedTaskDate = '2025-11-23';
    const updatedTaskPriority = 'Media';

    // Hook que executa antes de cada teste 'it()' neste bloco
    beforeEach(() => {
        // Garante um banco de dados limpo e semeado para cada teste
        cy.exec('php artisan migrate:fresh --seed --env=testing');

        // Faz o login do usuário antes de cada teste
        cy.visit('/login');
        cy.get('#email').type(userCredentials.email);
        cy.get('#password').type(userCredentials.password);
        cy.get('form#loginForm button[type="submit"]').click();
        cy.url().should('include', '/tasks'); // Confirma que o login foi bem-sucedido
    });

    context('Validações do Formulário de Criação de Tarefa', () => {
        beforeEach(() => {
            // Navega para a página de criação de tarefa
            cy.get('a[href*="/tasks/create"]').first().click();
            cy.url().should('include', '/tasks/create');
        });

        it('Deve exibir erro para título vazio', () => {
            // Tenta submeter o formulário sem preencher o título
            cy.get('form#taskForm button[type="submit"]').click();
            // Verifica a mensagem de erro inline para o título
            // O ID do erro é 'js-error-title' conforme a função showError em seu create.blade.php
            cy.get('#js-error-title').should('be.visible').and('contain.text', 'O título é obrigatório');
        });

        it('Deve exibir erro para data no passado', () => {
            // Gera uma data para "ontem"
            const yesterday = new Date();
            yesterday.setDate(yesterday.getDate() - 1);
            const yyyy = yesterday.getFullYear();
            const mm = String(yesterday.getMonth() + 1).padStart(2, '0');
            const dd = String(yesterday.getDate()).padStart(2, '0');
            const pastDate = `${yyyy}-${mm}-${dd}`;

            cy.get('#due_date').type(pastDate);
            // Clica em outro lugar para garantir que a validação client-side (se houver) seja acionada
            cy.get('body').click();
            // Submete o formulário para garantir que a validação de submit seja acionada
            cy.get('form#taskForm button[type="submit"]').click();
            cy.get('#js-error-due_date').should('be.visible').and('contain.text', 'A data limite não pode ser anterior a hoje.');
        });
    });

    context('Fluxo Completo de CRUD de uma Tarefa', () => {
        it('Deve criar, validar, editar, concluir e excluir uma tarefa', () => {
            // --- 1. CRIAR TAREFA ---
            cy.get('a[href*="/tasks/create"]').first().click();
            cy.get('#title').type(initialTaskTitle);
            cy.get('#description').type(initialTaskDescription);
            cy.get('#due_date').type(initialTaskDate);
            cy.get('#priority').select(initialTaskPriority);
            cy.get('form#taskForm button[type="submit"]').click();

            // --- 2. VALIDAR A CRIAÇÃO ---
            cy.url().should('include', '/tasks');
            cy.get('#swal2-title', { timeout: 10000 }).should('contain.text', 'Sucesso!');
            cy.get('#swal2-html-container').should('contain.text', 'Tarefa criada com sucesso!');

            cy.contains('.task-card h3', initialTaskTitle)
                .should('be.visible')
                .parents('.task-card')
                .as('taskCard'); // Salva uma referência ao card da tarefa

            cy.get('@taskCard').within(() => {
                cy.contains(initialTaskDescription).should('be.visible');
                cy.contains('10/10/2025').should('be.visible'); // Valida a data formatada
                cy.contains('Prioridade: Alta').should('be.visible');
            });

            // --- 3. EDITAR A TAREFA ---
            cy.get('@taskCard').find('a[title="Editar"]').click();
            cy.url().should('include', '/edit');

            cy.get('#title').clear().type(updatedTaskTitle);
            cy.get('#description').clear().type(updatedTaskDescription);
            cy.get('#due_date').type(updatedTaskDate);
            cy.get('#priority').select(updatedTaskPriority);
            cy.get('form#taskForm button[type="submit"]').click();

            // --- 4. VALIDAR A EDIÇÃO ---
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

            // --- 5. CONCLUIR A TAREFA ---
            cy.get('@updatedTaskCard').find('.complete-btn').as('completeButton');
            cy.get('@completeButton').click();

            cy.get('@completeButton').should('contain.text', 'Reabrir').and('have.class', 'bg-blue-600');
            cy.get('@updatedTaskCard').find('.task-complete').should('have.class', 'completed');

            // Reverte a conclusão
            cy.get('@completeButton').click();
            cy.get('@completeButton').should('contain.text', 'Concluir').and('have.class', 'bg-green-600');

            // --- 6. EXCLUIR A TAREFA ---
            cy.get('@updatedTaskCard').find('button[title="Excluir"]').click();

            cy.get('.swal2-confirm').contains('Sim, excluir!').click();

            // --- 7. VALIDAR A EXCLUSÃO ---
            cy.url().should('include', '/tasks');
            cy.get('#swal2-title').should('contain.text', 'Sucesso!');
            cy.get('#swal2-html-container').should('contain.text', 'Tarefa excluída com sucesso!');

            cy.contains('.task-card h3', updatedTaskTitle).should('not.exist');
            cy.get('.empty-state').should('be.visible').and('contain.text', 'Nenhuma tarefa encontrada');
        });
    });
});
