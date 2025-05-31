<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Tarefa - TaskManager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> {{-- Adicionado SweetAlert JS --}}
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
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           class="w-full px-4 py-2 border @error('title') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700">
                    @error('title')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full px-4 py-2 border @error('description') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Data Limite</label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}"
                               class="w-full px-4 py-2 border @error('due_date') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700">
                        @error('due_date')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Prioridade*</label>
                        <select name="priority" id="priority"
                                class="w-full px-4 py-2 border @error('priority') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700">
                            <option value="">Selecione...</option>
                            <option value="Alta" {{ old('priority') == 'Alta' ? 'selected' : '' }}>Alta</option>
                            {{-- Usando "Media" (sem acento) para o value, e "Média" (com acento) para o texto --}}
                            <option value="Media" {{ old('priority', 'Media') == 'Media' ? 'selected' : '' }}>Média</option>
                            <option value="Baixa" {{ old('priority') == 'Baixa' ? 'selected' : '' }}>Baixa</option>
                        </select>
                        @error('priority')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
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

{{-- SCRIPT PARA SWEETALERT DE ERROS DE VALIDAÇÃO DO BACKEND --}}
@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Erro de Validação!',
            html: `{!! implode('', $errors->all(':message<br>')) !!}`, // Mostra cada erro em uma nova linha
            confirmButtonText: 'OK',
            customClass: {
                htmlContainer: 'text-left' // Para alinhar o texto dos erros à esquerda
            }
        });
    </script>
@endif

{{-- SCRIPT PARA SWEETALERT DE SUCESSO (se você redirecionar de volta para create com 'success') --}}
@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif
</body>
</html>
