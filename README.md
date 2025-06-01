# TaskManager

Sistema de controle de tarefas e compromissos, feito para a atividade final da matéria de Desenvolvimento Web Mobile III.

## 📋 Descrição

O **TaskManager** é uma aplicação web desenvolvida em PHP (Laravel) com Blade, JavaScript e CSS. O objetivo é facilitar o gerenciamento de tarefas e compromissos de usuários, permitindo o cadastro, edição, visualização e exclusão de tarefas de maneira simples e intuitiva.

## 🚀 Funcionalidades

- Cadastro, edição e exclusão de tarefas
- Marcação de tarefas como concluídas ou pendentes
- Visualização de tarefas futuras e passadas
- Interface amigável e responsiva
- Organização de tarefas por data e prioridade

## 🛠️ Tecnologias Utilizadas

- **PHP** (Laravel)
- **Blade** (Template Engine)
- **JavaScript**
- **CSS**

## 📦 Instalação

1. Clone este repositório:
    ```bash
    git clone https://github.com/Vitor-Bobato/TaskManager.git
    ```
2. Acesse a pasta do projeto:
    ```bash
    cd TaskManager
    ```
3. Instale as dependências do Composer:
    ```bash
    composer install
    ```
4. Copie o arquivo de ambiente:
    ```bash
    cp .env.example .env
    ```
5. Gere a chave da aplicação:
    ```bash
    php artisan key:generate
    ```
6. Configure as variáveis de ambiente no arquivo `.env` (principalmente as informações do banco de dados).
7. Execute as migrations:
    ```bash
    php artisan migrate
    ```
8. Inicie o servidor de desenvolvimento:
    ```bash
    php artisan serve
    ```

## 👤 Autores

- [Vitor Bobato](https://github.com/Vitor-Bobato)
- [Paulo Cesar C. Domingues](https://github.com/Pcgo24)

## 📄 Licença

Este projeto está sob a licença MIT.

## ✉️ Contato

Em caso de dúvidas ou sugestões, entre em contato pelo [GitHub](https://github.com/Vitor-Bobato) ou [GitHub](https://github.com/Pcgo24)
