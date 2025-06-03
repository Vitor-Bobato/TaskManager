# TaskManager - Gerenciador de Tarefas

Bem-vindo ao TaskManager! Este é um aplicativo web construído com Laravel e PHP para ajudar os usuários a gerenciar suas tarefas diárias de forma eficiente, com foco na organização e produtividade.

## ✨ Funcionalidades Principais

O TaskManager oferece um conjunto robusto de funcionalidades para uma gestão de tarefas completa e segura:

### 👤 Autenticação de Usuários
* **Registro Detalhado:**
    * Campos: Nome Completo, Email, Senha e Confirmação de Senha.
    * Validação robusta no lado do cliente (JavaScript) e no backend (Laravel) para todos os campos.
    * **Regras de Senha Complexas:** Mínimo de 8 caracteres, exigência de letras maiúsculas, minúsculas, números e caracteres especiais.
    * Feedback visual instantâneo com mensagens de erro inline abaixo de cada campo.
    * Notificação de sucesso (via SweetAlert) após o registro, redirecionando para a página de login.
* **Login Seguro:**
    * Campos: Email e Senha.
    * Validação no lado do cliente e backend para campos obrigatórios e formato de email.
    * Notificação de sucesso (via SweetAlert) ao logar, redirecionando para a lista de tarefas.
    * Mensagem de erro clara para credenciais inválidas.
* **Logout:** Funcionalidade para encerrar a sessão do usuário de forma segura.
* **Segurança:** Utiliza o sistema de autenticação baseado em sessões do Laravel, com hashing de senhas (Bcrypt) e proteção CSRF.

### ამო Gerenciamento de Tarefas (CRUD Completo)
* **Criação de Tarefas:**
    * **Campos:** Título (obrigatório), Descrição (opcional), Data Limite (opcional), Prioridade (opcional).
    * **Validação Client-Side e Backend:**
        * Título: Obrigatório, máximo de 50 caracteres (validação JS) e 255 (backend).
        * Descrição: Máximo de 500 caracteres.
        * Data Limite: Se fornecida, deve ser a data atual ou futura.
    * **Comportamentos Padrão:**
        * Se a Data Limite não for fornecida, a tarefa exibe "Sem data limite".
        * Se a Prioridade não for selecionada, a tarefa é criada com prioridade "Baixa" por padrão (definido no banco de dados).
    * Notificação de sucesso (SweetAlert toast) ao criar.
* **Visualização de Tarefas (Multi-Tenancy):**
    * Cada usuário visualiza **apenas as tarefas que ele mesmo criou**.
    * Interface limpa e organizada, mostrando título, descrição, data limite e prioridade.
    * Destaque visual para prioridades (Alta, Média, Baixa) nos cards de tarefas.
    * Mensagem amigável ("Nenhuma tarefa encontrada") quando o usuário não possui tarefas.
* **Edição de Tarefas:**
    * Usuários podem editar apenas suas próprias tarefas.
    * Formulário pré-preenchido com os dados atuais da tarefa.
    * Validações aplicadas na edição, similares à criação.
    * Notificação de sucesso (SweetAlert toast) ao atualizar.
* **Exclusão de Tarefas:**
    * Usuários podem excluir apenas suas próprias tarefas.
    * Confirmação (SweetAlert) antes da exclusão definitiva para evitar perdas acidentais.
    * Notificação de sucesso (SweetAlert toast) ao excluir.
* **Interface do Usuário para Tarefas:**
    * Botão "Concluir" com efeito visual (a lógica de backend para marcar como concluída pode ser uma melhoria futura).
    * Contadores de caracteres para os campos de título e descrição no formulário de tarefas.

### 🎨 Frontend Moderno e Responsivo
* Estilização com **TailwindCSS**, proporcionando um design limpo e moderno.
* Ícones da biblioteca **Font Awesome**.
* Tipografia elegante com **Google Fonts (Poppins)**.
* Alertas e notificações interativas usando **SweetAlert2**.
* Validação de formulários em tempo real (client-side) com JavaScript puro, melhorando a experiência do usuário.
* Toggle para visualização de senha nos formulários de autenticação.

### ⚙️ Backend Robusto com Laravel
* Construído sobre o framework **Laravel** (versão mais recente utilizada no projeto, ex: Laravel 10 ou 11, com base no uso do `Password::defaults()`).
* Banco de dados **MySQL**.
* **Eloquent ORM** para interações com o banco de dados, com models `User` e `Task` e seus respectivos relacionamentos (`User hasMany Tasks`, `Task belongsTo User`).
* **Migrations** para gerenciamento da estrutura do banco de dados (tabelas `users`, `password_reset_tokens`, `sessions`, `cache`, `jobs`, `failed_jobs`, `tasks`).
* **Seeders** (`UserSeeder`, `TaskSeeder`) para popular o banco de dados com dados de teste/iniciais.
* Validação de requisições no backend para garantir a integridade dos dados.
* Sistema de **Logging** para eventos importantes (criação de tarefas, listagem).

### 🧪 Testes Automatizados
* Configuração de um **banco de dados de teste separado** (`taskmanager_test`) usando um arquivo de ambiente dedicado (`.env.cypress`).
* Uso do comando `php artisan migrate:fresh --seed --env=cypress` para preparar o ambiente de teste antes da execução dos testes E2E.
* Testes End-to-End (E2E) com **Cypress** cobrindo:
    * Fluxo completo de registro de usuário, incluindo todas as validações de campo (obrigatório, formato, tamanho, complexidade de senha, e-mail único).
    * Fluxo completo de login, incluindo validações.
    * Funcionalidades CRUD de tarefas.
    * Verificação da regra de multi-tenancy (usuário só vê suas próprias tarefas).

## 🛠️ Tecnologias Utilizadas

* **Backend:** PHP, Laravel
* **Frontend:** HTML5, TailwindCSS, JavaScript (Vanilla JS)
* **Banco de Dados:** MySQL
* **Ferramentas Adicionais:** Font Awesome (ícones), Google Fonts (tipografia), SweetAlert2 (alertas)
* **Testes:** Cypress (E2E)

## 🚀 Configuração e Instalação (Desenvolvimento)

1.  **Pré-requisitos:**
    * PHP (conforme a versão do Laravel, ex: >= 8.1)
    * Composer
    * Node.js e NPM (ou Yarn)
    * Servidor MySQL

2.  **Clone o Repositório:**
    ```bash
    git clone <URL_DO_SEU_REPOSITORIO>
    cd TaskManager
    ```

3.  **Instale as Dependências:**
    ```bash
    composer install
    npm install
    npm run dev # Ou npm run build, dependendo da sua configuração de assets
    ```

4.  **Configuração do Ambiente:**
    * Copie `.env.example` para `.env`: `cp .env.example .env`
    * Gere a chave do aplicativo: `php artisan key:generate`
    * Configure as variáveis de ambiente no arquivo `.env`, especialmente as de banco de dados ( `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
    * Certifique-se de que o banco de dados (`DB_DATABASE` definido no `.env`) exista no seu MySQL.

5.  **Execute as Migrations e Seeders (opcional para seeders):**
    ```bash
    php artisan migrate
    # php artisan db:seed # Se quiser popular com dados iniciais
    ```

6.  **Inicie o Servidor de Desenvolvimento:**
    ```bash
    php artisan serve
    ```
    A aplicação estará disponível em `http://127.0.0.1:8000` (ou na `APP_URL` definida).

## 🧪 Executando os Testes Cypress

1.  **Configure o Ambiente de Teste:**
    * Copie seu arquivo `.env` para `.env.cypress`.
    * No arquivo `.env.cypress`, altere `APP_ENV` para `testing` e `DB_DATABASE` para um nome de banco de dados dedicado a testes (ex: `taskmanager_test`).
        ```ini
        APP_ENV=testing
        DB_DATABASE=taskmanager_test
        # Certifique-se que as outras credenciais de DB estão corretas
        # e que APP_KEY está definida.
        ```
    * Crie manualmente o banco de dados `taskmanager_test` no seu MySQL.

2.  **Inicie o Servidor para Testes:**
    É crucial que o servidor Laravel use o ambiente de teste:
    ```bash
    php artisan serve --env=cypress
    ```

3.  **Abra o Cypress:**
    Em outro terminal, na raiz do projeto:
    ```bash
    npx cypress open
    ```
    Selecione os testes E2E e execute os arquivos de especificação (ex: `registration.cy.js`, `tasks_crud.cy.js`). Os testes usarão o comando `php artisan migrate:fresh --seed --env=cypress` para preparar o banco de dados de teste.

## 🏛️ Estrutura do Projeto (Visão Geral)

O projeto segue a estrutura padrão do Laravel:
* `app/Http/Controllers/`: Contém os controllers para `LoginController`, `RegisterController`, `TaskController`.
* `app/Models/`: Contém os models Eloquent `User.php` e `Task.php`.
* `database/migrations/`: Contém as migrações para a estrutura do banco de dados.
* `database/seeders/`: Contém os seeders (`UserSeeder`, `TaskSeeder`, `DatabaseSeeder`).
* `database/factories/`: Contém as factories para gerar dados de teste (`UserFactory`, `TaskFactory`).
* `resources/views/`: Contém as views Blade.
    * `auth/`: Views para login e registro.
    * `tasks/`: Views para CRUD de tarefas (index, create, edit).
    * `layouts/`: (Se você tiver layouts principais).
* `routes/web.php`: Define as rotas da aplicação web.
* `public/`: Ponto de entrada e assets públicos (CSS, JS compilados, se houver).
* `cypress/e2e/`: Contém os arquivos de teste End-to-End do Cypress.

---
