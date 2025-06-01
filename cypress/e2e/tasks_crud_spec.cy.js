describe('CRUD de Tarefas (Sem Autenticação)', () => {
    // Gerar dados únicos para cada execução de teste
    const testTimestamp = Date.now();
    const taskTitle = `Nova Tarefa Cypress - ${testTimestamp}`;
    const taskDescription = 'Esta é uma descrição detalhada para a tarefa de teste Cypress.';

    // CORRIGIDO: Valor para o select e para o backend
    const taskPriorityValue = 'Media';
    // CORRIGIDO: Texto exibido para o usuário
    const taskPriorityText = 'Média';

    const updatedTaskTitle = `Tarefa Cypress Editada - ${testTimestamp}`;
    const updatedTaskPriorityValue = 'Alta';
    const updatedTaskPriorityText = 'Alta';


    beforeEach(() => {
        // Visita a página de listagem de tarefas antes de cada teste
        cy.visit('/tasks');
    });

    it('deve permitir criar, visualizar, editar e excluir uma tarefa', () => {
        // --- 0. VERIFICAR ESTADO INICIAL (OPCIONAL) ---
        cy.contains('h1', 'TaskManager').should('be.visible');
        // Adicione asserções sobre o estado inicial da lista se necessário

        // --- 1. NAVEGAR PARA CRIAÇÃO E VALIDAR CAMPOS OBRIGATÓRIOS ---
        cy.contains('a', 'Criar tarefa').first().click();
        cy.url().should('include', '/tasks/create');
        cy.contains('h1', 'Criar Nova Tarefa').should('be.visible');

        cy.get('button[type="submit"]').contains('Salvar').click();
        cy.get('.swal2-popup .swal2-html-container', { timeout: 10000 })
            .should('be.visible')
            .and('contain.text', 'O campo title é obrigatório.')
            .and('contain.text', 'O campo priority é obrigatório.');
        cy.get('.swal2-confirm').click();

        // --- 2. CRIAR UMA NOVA TAREFA ---
        cy.get('#title').type(taskTitle);
        cy.get('#description').type(taskDescription);
        // CORRIGIDO: Seleciona pelo VALOR "Media" (sem acento)
        cy.get('#priority').select(taskPriorityValue);

        cy.intercept('POST', '/tasks').as('createTask');
        cy.get('button[type="submit"]').contains('Salvar').click();

        cy.wait('@createTask').its('response.statusCode').should('eq', 302);
        cy.url().should('include', '/tasks');
        cy.get('.swal2-popup .swal2-html-container', { timeout: 10000 })
            .should('be.visible')
            .and('contain.text', 'Tarefa criada com sucesso!');
        cy.get('button.swal2-confirm, .swal2-timer-progress-bar-container button').filter(':visible').first().click({ force: true });

        // --- 3. VERIFICAR A TAREFA CRIADA NA LISTA ---
        cy.contains('.task-card', taskTitle, { timeout: 10000 }).as('taskCard');

        cy.get('@taskCard').find('h3').should('contain.text', taskTitle);
        cy.get('@taskCard').find('p').first().should('contain.text', taskDescription);

        // CORRIGIDO: Verifica a classe de borda para "Media"
        cy.get('@taskCard').should('have.class', 'border-yellow-600');
        // CORRIGIDO: Verifica o texto exibido "Média" e a classe de cor do texto
        cy.get('@taskCard').find('div.text-sm')
            .contains(`Prioridade: ${taskPriorityText}`)
            .should('have.class', 'text-yellow-600');

        // --- 4. NAVEGAR PARA EDIÇÃO E VERIFICAR DADOS PREENCHIDOS ---
        cy.get('@taskCard').find('a[title="Editar"]').click();
        cy.url().should('match', /\/tasks\/\d+\/edit$/);
        cy.contains('h1', 'Editar Tarefa').should('be.visible');

        cy.get('#title').should('have.value', taskTitle);
        cy.get('#description').should('have.value', taskDescription);
        // CORRIGIDO: Verifica o VALOR "Media" selecionado
        cy.get('#priority').should('have.value', taskPriorityValue);

        // --- 5. EDITAR A TAREFA ---
        cy.get('#title').clear().type(updatedTaskTitle);
        cy.get('#priority').select(updatedTaskPriorityValue);

        cy.intercept('PUT', /\/tasks\/\d+$/).as('updateTask');
        cy.get('button[type="submit"]').contains('Atualizar').click();

        cy.wait('@updateTask').its('response.statusCode').should('eq', 302);
        cy.url().should('include', '/tasks');
        cy.get('.swal2-popup .swal2-html-container', { timeout: 10000 })
            .should('be.visible')
            .and('contain.text', 'Tarefa atualizada com sucesso!');
        cy.get('button.swal2-confirm, .swal2-timer-progress-bar-container button').filter(':visible').first().click({ force: true });

        // --- 6. VERIFICAR A TAREFA EDITADA NA LISTA ---
        cy.contains('.task-card', updatedTaskTitle, { timeout: 10000 }).as('updatedTaskCard');

        cy.get('@updatedTaskCard').find('h3').should('contain.text', updatedTaskTitle);
        cy.get('@updatedTaskCard').should('have.class', 'border-red-800');
        cy.get('@updatedTaskCard').find('div.text-sm')
            .contains(`Prioridade: ${updatedTaskPriorityText}`)
            .should('have.class', 'text-red-800');

        // --- 7. EXCLUIR A TAREFA ---
        cy.get('@updatedTaskCard').find('button[title="Excluir"]').click();

        cy.intercept('DELETE', /\/tasks\/\d+$/).as('deleteTask');
        cy.wait('@deleteTask').its('response.statusCode').should('eq', 302);

        cy.url().should('include', '/tasks');
        cy.get('.swal2-popup .swal2-html-container', { timeout: 10000 })
            .should('be.visible')
            .and('contain.text', 'Tarefa excluída com sucesso!');
        cy.get('button.swal2-confirm, .swal2-timer-progress-bar-container button').filter(':visible').first().click({ force: true });

        // --- 8. VERIFICAR SE A TAREFA FOI EXCLUÍDA ---
        cy.contains('.task-card h3', updatedTaskTitle).should('not.exist');
        // cy.contains('Nenhuma tarefa encontrada').should('be.visible'); // Opcional/Condicional
    });
});
