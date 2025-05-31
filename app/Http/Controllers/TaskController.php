<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        Log::info('Listagem de tarefas acessada', ['quantidade' => $tasks->count()]);


        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate
        ([
            'title' => ['required', 'regex:/[A-Za-zÀ-ÿ]/', 'max:255'],
            'description' => ['required', 'regex:/[A-Za-zÀ-ÿ]/'],
            'due_date' => 'nullable|date',
            'priority' => 'required|in:Alta,Media,Baixa',
        ]);

        $data = $request->all();
        if (empty($data['due_date'])) {
            $data['due_date'] = null;
        }

        $task = Task::create($data);

        Log::info('Tarefa criada', ['id' => $task->id, 'title' => $task->title]);


        return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso!');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tarefa excluída com sucesso!');
    }

    public function edit($id) {
    $task = Task::findOrFail($id);
    return view('tasks.edit', compact('task'));
}

public function update(Request $request, $id) {
    $task = Task::findOrFail($id);
    // Validação dos dados
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        // Adicione outros campos conforme necessário
    ]);
    $task->update($validated);
    return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada com sucesso!');
}


}
