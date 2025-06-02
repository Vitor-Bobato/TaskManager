// php artisan serve --env=cypress

describe('Funcionalidades de Tarefas TaskManager', () => {
    const uniqueEmail = () => `taskuser_${Date.now()}@example.com`;
    const testPassword = 'Password123!';

    beforeEach(() => {
        // Para cada teste de tarefa, precisamos estar logados.
        // É uma boa prática criar um comando customizado para login.
        // Por agora, vamos registrar e logar programaticamente.
        const email = uniqueEmail();
        cy.request({
            method: 'POST',
            url: '/register', // Ajuste a URL base se necessário
            form: true,
            body: {
                _token: '', // Lidar com CSRF
                nome_completo: 'Task Test User',
                email: email,
                password: testPassword,
                password_confirmation: testPassword
            },
            onBeforeLoad(win) {
                const token = win.document.querySelector('meta[name="csrf-token"]');
                if (token) { this.body._token = token.content; }
            }
        });

        cy.visit('/login'); // Ajuste a URL base se necessário
        cy.get('input#email').type(email);
        cy.get('input#password').type(testPassword);
        cy.get('button[type="submit"]').click();
        cy.url().should('include', '/tasks');
    });

    it('Deve criar uma nova tarefa com sucesso', () => {
        cy.visit('/tasks/create');

        const taskTitle = `Nova Tarefa - ${Date.now()}`;
        const taskDescription = 'Descrição da nova tarefa.';

        cy.get('input#title').type(taskTitle);
        cy.get('textarea#description').type(taskDescription);
        cy.get('input#due_date').type('2025-12-31'); // Use uma data futura válida
        cy.get('select#priority').select('Alta');
        cy.get('button[type="submit"]').contains('Criar Tarefa').click();

        cy.url().should('include', '/tasks');
        cy.contains('Tarefa criada com sucesso!').should('be.visible');
        cy.contains(taskTitle).should('be.visible');
        cy.contains(taskDescription).should('be.visible');
    });

    it('Deve exibir erros de validação ao criar tarefa com dados inválidos', () => {
        cy.visit('/tasks/create');

        cy.get('button[type="submit"]').contains('Criar Tarefa').click(); // Tenta submeter formulário vazio

        // Client-side (JS em create.blade.php) - a função showError deveria criar elementos com 'error-message-js'
        // Se a validação for primariamente server-side, os erros virão do Laravel
        cy.get('input#title').siblings('.error-message-js, .text-red-500').should('contain', 'O título é obrigatório'); // Ajuste o seletor

        // Testar limite de caracteres (se houver validação JS visível para isso)
        const longTitle = 'a'.repeat(60); // Seu create.blade.php valida max 50 no JS e 255 no controller
        cy.get('input#title').clear().type(longTitle);
        // Verificar o contador de caracteres se implementado para mostrar erro
        cy.get('#counter-title').should('contain', '60/50').and('have.class', 'over');
        // A validação JS pode impedir o submit ou mostrar erro

        // Testar data passada (se houver validação JS visível)
        cy.get('input#due_date').clear().type('2020-01-01');
        // ... (se a validação JS mostrar um erro específico)

        // Forçar submissão para pegar erros do backend se JS for contornado ou incompleto
        // cy.get('form#taskForm').submit(); // Pode ser necessário para forçar se o botão estiver desabilitado
        // E então verificar erros do Laravel (SweetAlert de erro ou mensagens de erro no campo)
    });

    it('Deve listar as tarefas existentes', () => {
        // Criar uma tarefa primeiro para garantir que há algo para listar
        const taskTitle = `Tarefa Visível - ${Date.now()}`;
        cy.visit('/tasks/create');
        cy.get('input#title').type(taskTitle);
        cy.get('textarea#description').type('Verificando a listagem.');
        cy.get('button[type="submit"]').contains('Criar Tarefa').click();
        cy.contains('Tarefa criada com sucesso!').should('be.visible'); // Confirmação

        cy.visit('/tasks');
        cy.contains(taskTitle).should('be.visible');
        cy.contains('Verificando a listagem.').should('be.visible');
    });

    it('Deve editar uma tarefa existente com sucesso', () => {
        // 1. Criar uma tarefa
        const originalTitle = `Tarefa para Editar - ${Date.now()}`;
        cy.visit('/tasks/create');
        cy.get('input#title').type(originalTitle);
        cy.get('button[type="submit"]').contains('Criar Tarefa').click();
        cy.url().should('include', '/tasks');
        cy.contains(originalTitle).should('be.visible');

        // 2. Encontrar a tarefa na lista e clicar em editar
        // O seletor aqui assume que cada .task-card contém um título e um botão de edição
        cy.contains('.task-card', originalTitle).within(() => {
            cy.get('a[title="Editar"]').click();
        });

        // 3. Editar a tarefa
        const updatedTitle = `Tarefa Editada - ${Date.now()}`;
        const updatedDescription = 'Descrição atualizada.';
        cy.url().should('include', '/edit');
        cy.get('input#title').clear().type(updatedTitle);
        cy.get('textarea#description').clear().type(updatedDescription);
        cy.get('select#priority').select('Media');
        cy.get('button[type="submit"]').contains('Atualizar Tarefa').click();

        // 4. Verificar se a tarefa foi atualizada na lista
        cy.url().should('include', '/tasks');
        cy.contains('Tarefa atualizada com sucesso!').should('be.visible');
        cy.contains(updatedTitle).should('be.visible');
        cy.contains(updatedDescription).should('be.visible');
        cy.contains(originalTitle).should('not.exist');
    });

    it('Deve excluir uma tarefa existente', () => {
        // 1. Criar uma tarefa
        const taskTitleToDelete = `Tarefa para Excluir - ${Date.now()}`;
        cy.visit('/tasks/create');
        cy.get('input#title').type(taskTitleToDelete);
        cy.get('button[type="submit"]').contains('Criar Tarefa').click();
        cy.url().should('include', '/tasks');
        cy.contains(taskTitleToDelete).should('be.visible');

        // 2. Encontrar a tarefa e clicar em excluir
        cy.contains('.task-card', taskTitleToDelete).within(() => {
            cy.get('button[title="Excluir"]').click();
        });

        // 3. Confirmar a exclusão no SweetAlert
        // Os seletores do SweetAlert podem precisar de ajuste
        cy.get('.swal2-confirm').contains('Sim, excluir!').click();

        // 4. Verificar se a tarefa foi excluída
        cy.contains('Tarefa excluída com sucesso!').should('be.visible');
        cy.contains(taskTitleToDelete).should('not.exist');
    });

    it('Deve marcar uma tarefa como concluída (UI toggle)', () => {
        const taskTitleToComplete = `Tarefa para Concluir - ${Date.now()}`;
        cy.visit('/tasks/create');
        cy.get('input#title').type(taskTitleToComplete);
        cy.get('button[type="submit"]').contains('Criar Tarefa').click();
        cy.contains(taskTitleToComplete).should('be.visible');

        cy.contains('.task-card', taskTitleToComplete).within(() => {
            // Verifica estado inicial do botão
            cy.get('button.complete-btn').should('contain', 'Concluir');
            // Verifica que o título não tem a classe 'completed' (ou o estilo aplicado)
            cy.get('.task-complete').should('not.have.class', 'completed');

            // Clica para concluir
            cy.get('button.complete-btn').click();

            // Verifica estado alterado
            cy.get('button.complete-btn').should('contain', 'Reabrir');
            cy.get('.task-complete').should('have.class', 'completed'); // ou verificar o ::after style se possível

            // Clica para reabrir
            cy.get('button.complete-btn').click();
            cy.get('button.complete-btn').should('contain', 'Concluir');
            cy.get('.task-complete').should('not.have.class', 'completed');
        });
    });
});
