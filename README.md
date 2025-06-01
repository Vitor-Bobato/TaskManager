
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>TaskManager - Sistema de Controle de Tarefas</title>
  <style>
    body {
      font-family: "Segoe UI", Arial, sans-serif;
      background: linear-gradient(135deg, #ece9f7 0%, #d1cfe2 100%);
      color: #22223b;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 900px;
      margin: 40px auto;
      padding: 32px 40px;
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 8px 32px rgba(44, 44, 62, 0.13);
    }
    h1, h2, h3 {
      color: #5f4b8b;
      margin-top: 0;
    }
    h1 span {
      font-size: 0.65em;
      color: #3d375e;
      font-weight: 400;
    }
    .badges {
      margin-bottom: 24px;
    }
    .badge {
      display: inline-block;
      background: #5f4b8b;
      color: #fff;
      border-radius: 8px;
      font-size: 13px;
      padding: 3px 14px;
      margin-right: 7px;
      margin-bottom: 3px;
      text-decoration: none;
    }
    pre {
      background: #f7f7fb;
      color: #22223b;
      padding: 14px 18px;
      border-radius: 8px;
      font-size: 15px;
      overflow-x: auto;
    }
    code {
      background: #f3f0fa;
      padding: 2px 7px;
      border-radius: 4px;
      font-size: 15px;
    }
    ul {
      line-height: 1.7;
    }
    a {
      color: #5f4b8b;
      text-decoration: underline;
    }
    .footer {
      margin-top: 40px;
      text-align: center;
      color: #aba7c3;
    }
    @media (max-width: 700px) {
      .container { padding: 18px 4vw; }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>
      TaskManager <span>• Sistema de Controle de Tarefas e Compromissos</span>
    </h1>

    <div class="badges">
      <span class="badge">PHP</span>
      <span class="badge">Blade</span>
      <span class="badge">JavaScript</span>
      <span class="badge">CSS</span>
      <span class="badge">Mobile Web</span>
    </div>

    <p>
      O <b>TaskManager</b> é um sistema moderno para controle de tarefas e compromissos, desenvolvido para a disciplina de <i>Desenvolvimento Web Mobile III</i>. Ele permite que usuários gerenciem suas atividades diárias de forma fácil, intuitiva e responsiva.
    </p>

    <h2>🚀 Principais Funcionalidades</h2>
    <ul>
      <li>✅ Cadastro, edição e exclusão de tarefas</li>
      <li>⏰ Acompanhamento de prazos e status</li>
      <li>📅 Visualização de agenda</li>
      <li>🔍 Filtros e busca de tarefas</li>
      <li>📱 Layout responsivo para dispositivos móveis</li>
    </ul>

    <h2>📦 Tecnologias Utilizadas</h2>
    <ul>
      <li><b>PHP</b> – Backend e lógica de negócio</li>
      <li><b>Blade</b> – Template engine do Laravel</li>
      <li><b>JavaScript</b> – Interatividade e dinamicidade no front-end</li>
      <li><b>CSS</b> – Estilização moderna e responsiva</li>
    </ul>

    <h2>🔧 Como Rodar o Projeto</h2>
    <ol>
      <li>Clone o repositório:
        <pre><code>git clone https://github.com/Vitor-Bobato/TaskManager.git</code></pre>
      </li>
      <li>Instale as dependências do PHP e front-end (Laravel, Composer, NPM/Yarn):<br>
        <pre><code>cd TaskManager
composer install
npm install
npm run dev</code></pre>
      </li>
      <li>Configure o arquivo <code>.env</code> com suas informações de banco de dados e execute as migrations:
        <pre><code>php artisan migrate</code></pre>
      </li>
      <li>Inicie o servidor de desenvolvimento:
        <pre><code>php artisan serve</code></pre>
      </li>
      <li>Acesse <a href="http://localhost:8000" target="_blank">http://localhost:8000</a></li>
    </ol>

    <h2>👨‍💻 Contribuição</h2>
    <ul>
      <li>Fork este repositório</li>
      <li>Crie uma branch para sua feature (<code>git checkout -b minha-feature</code>)</li>
      <li>Commit suas alterações (<code>git commit -m 'feat: minha nova feature'</code>)</li>
      <li>Abra um Pull Request</li>
    </ul>

    <h2>📄 Licença</h2>
    <p>Este projeto foi desenvolvido para fins acadêmicos e está sob a licença <b>MIT</b>.</p>

    <div class="footer">
      <hr>
      <p>
        Desenvolvido por <b>Vitor Bobato</b> para a disciplina de Desenvolvimento Web Mobile III.<br>
        <a href="https://github.com/Vitor-Bobato/TaskManager" target="_blank">Repositório no GitHub</a>
      </p>
    </div>
  </div>
</body>
</html>
