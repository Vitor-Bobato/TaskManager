<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Tarefa - TaskManager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200 min-h-screen flex items-center justify-center py-8">
    <div class="w-full max-w-md px-4">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-green-700 px-6 py-4">
                <h1 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Criar Nova Tarefa
                </h1>
            </div>

            <form method="POST" action="{{ route('tasks.store') }}" class="p-6">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título*</label>
                        <input type="text" name="title" id="title" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                        <textarea name="description" id="description" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Data Limite</label>
                            <input type="date" name="due_date" id="due_date"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700">
                        </div>

                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Prioridade*</label>
                            <select name="priority" id="priority" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700">
                                <option value="Alta">Alta</option>
                                <option value="Media" selected>Média</option>
                                <option value="Baixa">Baixa</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between mt-6">
                    <a href="{{ route('tasks.index') }}"
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Voltar
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-600 flex items-center">
                        <i class="fas fa-save mr-2"></i> Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
