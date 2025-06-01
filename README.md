<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskManager - Gerenciador de Tarefas</title>
    <style>
        :root {
            --primary: #4F46E5;
            --secondary: #10B981;
            --dark: #1F2937;
            --light: #F9FAFB;
            --gray: #6B7280;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--dark);
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: var(--light);
        }
        
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        h1, h2, h3 {
            color: var(--primary);
        }
        
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            border-bottom: 3px solid var(--primary);
            padding-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        h2 {
            font-size: 1.8rem;
            margin-top: 30px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        h3 {
            font-size: 1.4rem;
            margin-top: 25px;
        }
        
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            background-color: var(--primary);
            color: white;
            margin-right: 8px;
        }
        
        .tech-badge {
            background-color: var(--secondary);
        }
        
        ul, ol {
            padding-left: 20px;
        }
        
        li {
            margin-bottom: 8px;
        }
        
        code {
            background-color: #F3F4F6;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', Courier, monospace;
            color: var(--dark);
        }
        
        pre {
            background-color: #1E1E1E;
            color: #D4D4D4;
            padding: 15px;
            border-radius: 6px;
            overflow-x: auto;
            font-family: 'Courier New', Courier, monospace;
        }
        
        a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        
        a:hover {
            text-decoration: underline;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .feature-card {
            background: white;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .feature-card h3 {
            margin-top: 0;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .authors {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .author-card {
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            width: fit-content;
        }
        
        .emoji {
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>
            <span class="emoji">📋</span>
            TaskManager
        </h1>
        
        <p>Um sistema completo para gerenciamento de tarefas e compromissos, desenvolvido como projeto final para a disciplina de Desenvolvimento Web Mobile III.</p>
        
        <h2>
            <span class="emoji">✨</span>
            Descrição
        </h2>
        
        <p>O <strong>TaskManager</strong> é uma aplicação web desenvolvida em PHP (Laravel) com Blade, JavaScript e CSS. Seu objetivo principal é facilitar o gerenciamento de tarefas e compromissos dos usuários, oferecendo uma experiência simples, intuitiva e eficiente.</p>
        
        <h2>
            <span class="emoji">🚀</span>
            Funcionalidades
        </h2>
        
        <div class="features-grid">
            <div class="feature-card">
                <h3><span class="emoji">📝</span> Gestão de Tarefas</h3>
                <ul>
                    <li>Cadastro rápido e intuitivo</li>
                    <li>Edição completa de detalhes</li>
                    <li>Exclusão segura de itens</li>
                </ul>
            </div>
            
            <div class="feature-card">
                <h3><span class="emoji">✅</span> Status</h3>
                <ul>
                    <li>Marcação como concluída</li>
                    <li>Visualização de pendências</li>
                    <li>Filtros por status</li>
                </ul>
            </div>
            
            <div class="feature-card">
                <h3><span class="emoji">🗓️</span> Organização</h3>
                <ul>
                    <li>Visualização por data</li>
                    <li>Filtros por período</li>
                    <li>Ordenação por prioridade</li>
                </ul>
            </div>
            
            <div class="feature-card">
                <h3><span class="emoji">💻</span> Interface</h3>
                <ul>
                    <li>Design responsivo</li>
                    <li>Navegação intuitiva</li>
                    <li>Experiência otimizada</li>
                </ul>
            </div>
        </div>
        
        <h2>
            <span class="emoji">🛠️</span>
            Tecnologias Utilizadas
        </h2>
        
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <span class="badge tech-badge">PHP</span>
            <span class="badge tech-badge">Laravel</span>
            <span class="badge tech-badge">Blade</span>
            <span class="badge tech-badge">JavaScript</span>
            <span class="badge tech-badge">CSS</span>
            <span class="badge tech-badge">HTML5</span>
        </div>
        
        <h2>
            <span class="emoji">📦</span>
            Instalação
        </h2>
        
        <ol>
            <li>Clone este repositório:
                <pre><code>git clone https://github.com/Vitor-Bobato/TaskManager.git</code></pre>
            </li>
            <li>Acesse a pasta do projeto:
                <pre><code>cd TaskManager</code></pre>
            </li>
            <li>Instale as dependências do Composer:
                <pre><code>composer install</code></pre>
            </li>
            <li>Copie o arquivo de ambiente:
                <pre><code>cp .env.example .env</code></pre>
            </li>
            <li>Gere a chave da aplicação:
                <pre><code>php artisan key:generate</code></pre>
            </li>
            <li>Configure as variáveis de ambiente no arquivo <code>.env</code> (principalmente as informações do banco de dados)</li>
            <li>Execute as migrations:
                <pre><code>php artisan migrate</code></pre>
            </li>
            <li>Inicie o servidor de desenvolvimento:
                <pre><code>php artisan serve</code></pre>
            </li>
        </ol>
        
        <h2>
            <span class="emoji">👥</span>
            Autores
        </h2>
        
        <div class="authors">
            <div class="author-card">
                <span class="emoji">👨‍💻</span>
                <div>
                    <strong>Vitor Bobato</strong>
                    <div><a href="https://github.com/Vitor-Bobato" target="_blank">GitHub</a></div>
                </div>
            </div>
            
            <div class="author-card">
                <span class="emoji">👨‍💻</span>
                <div>
                    <strong>Paulo Cesar C. Domingues</strong>
                    <div><a href="https://github.com/Pcgo24" target="_blank">GitHub</a></div>
                </div>
            </div>
        </div>
        
        <h2>
            <span class="emoji">📄</span>
            Licença
        </h2>
        
        <p>Este projeto está sob a licença <strong>MIT</strong>.</p>
        
        <h2>
            <span class="emoji">✉️</span>
            Contato
        </h2>
        
        <p>Em caso de dúvidas ou sugestões, entre em contato pelo <a href="https://github.com/Vitor-Bobato" target="_blank">GitHub</a>.</p>
    </div>
</body>
</html>
