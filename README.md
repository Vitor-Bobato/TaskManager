<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>TaskManager - Sistema de Controle de Tarefas</title>
  <style>
    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      background: #f7fafc;
      margin: 0;
      padding: 0;
      color: #222;
    }
    .container {
      max-width: 780px;
      margin: 40px auto;
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 6px 32px rgba(0,0,0,0.08);
      padding: 38px 32px 32px 32px;
    }
    h1 {
      font-size: 2.5rem;
      color: #3f51b5;
      margin-bottom: 4px;
      letter-spacing: 1px;
    }
    .subtitle {
      color: #6b7280;
      margin-bottom: 24px;
      font-size: 1.15rem;
      border-left: 4px solid #3f51b5;
      padding-left: 10px;
    }
    h2 {
      color: #3f51b5;
      margin-top: 2.2em;
      margin-bottom: 1em;
      font-size: 1.4rem;
      letter-spacing: .5px;
    }
    ul {
      margin: 0 0 1.2em 1.2em;
      padding: 0;
      line-height: 1.7;
    }
    ol {
      margin: 0 0 1.2em 1.2em;
      padding: 0;
      line-height: 1.7;
    }
    code, pre {
      background: #f0f4f8;
      border-radius: 5px;
      padding: 2px 8px;
      color: #1a202c;
    }
    .authors {
      display: flex;
      gap: 2em;
      margin-top: 20px;
    }
    .author-card {
      background: #eff6ff;
      border-radius: 8px;
      padding: 14px 20px;
      min-width: 170px;
      text-align: center;
      box-shadow: 0 2px 8px rgba(63,81,181,.07);
    }
    .author-card strong {
      color: #3f51b5;
      font-size: 1.07em;
      letter-spacing: .7px;
    }
    .license {
      background: #f7fafc;
      border-left: 4px solid #3f51b5;
      padding: 12px 16px;
      font-size: 1.02em;
      margin-top: 18px;
      color: #555;
    }
    .tech-list {
      display: flex;
      flex-wrap: wrap;
      gap: 1em;
      margin-bottom: 1.4em;
    }
    .tech-item {
      background: #e3eafc;
      color: #223;
      border-radius: 8px;
      padding: 6px 16px;
      font-weight: 500;
      font-size: 1em;
      box-shadow: 0 1px 4px rgba(63,81,181,.07);
    }
    a {
      color: #3f51b5;
      text-decoration: none;
      font-weight: 500;
    }
    a:hover {
      text-decoration: underline;
    }
    @media (max-width: 700px) {
      .container { padding: 16px 6vw; }
      .authors { flex-direction: column; gap: 1em; }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>📋 TaskManager</h1>
    <div class="subtitle">
      Sistema de controle de tarefas e compromissos — Projeto final da disciplina <b>Desenvolvimento Web Mobile III</b>.
    </div>

    <h2>🌟 Visão Geral</h2>
    <p>
      O <b>TaskManager</b> é uma aplicação web desenvolvida para ajudar você a organizar tarefas e compromissos do seu dia a dia com praticidade e eficiência. Cadastre, edite e acompanhe o progresso de suas atividades de forma simples, visual e moderna.
    </p>

    <h2>🚦 Funcionalidades Principais</h2>
    <ul>
      <li>Adicionar, editar e excluir tarefas</li>
      <li>Listagem clara de todas as tarefas</li>
      <li>Marcar tarefas como concluídas</li>
      <li>Interface limpa, responsiva e intuitiva</li>
      <li>Filtros para visualizar pendências e concluídas</li>
    </ul>

    <h2>🛠️ Tecnologias Utilizadas</h2>
    <div class="tech-list">
      <div class="tech-item">PHP</div>
      <div class="tech-item">Blade (Laravel)</div>
      <div class="tech-item">JavaScript</div>
      <div class="tech-item">CSS</div>
    </div>

    <h2>🚀 Como Rodar o Projeto</h2>
    <ol>
      <li>Clone este repositório:<br>
        <code>git clone https://github.com/Vitor-Bobato/TaskManager.git</code>
      </li>
      <li>Entre no diretório do projeto:<br>
        <code>cd TaskManager</code>
      </li>
      <li>Instale as dependências (Composer):<br>
        <code>composer install</code>
      </li>
      <li>Configure o arquivo <code>.env</code> com os dados do seu banco de dados.</li>
      <li>Execute as migrations (caso utilize Laravel):<br>
        <code>php artisan migrate</code>
      </li>
      <li>Inicie o servidor:<br>
        <code>php artisan serve</code>
      </li>
      <li>
        Acesse <a href="http://localhost:8000" target="_blank">http://localhost:8000</a> no seu navegador.
      </li>
    </ol>

    <h2>👨‍💻 Autores</h2>
    <div class="authors">
      <div class="author-card">
        <strong>Vitor Bobato</strong><br>
        <a href="https://github.com/Vitor-Bobato" target="_blank">@Vitor-Bobato</a>
      </div>
      <div class="author-card">
        <strong>Paulo Cesar Cardoso Domingues</strong>
      </div>
    </div>

    <h2>📄 Licença</h2>
    <div class="license">
      Este projeto tem fins exclusivamente acadêmicos e não possui licença comercial.
    </div>
  </div>
</body>
</html>
