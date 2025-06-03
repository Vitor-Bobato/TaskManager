<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
//        $tasks = Task::all();


        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar as tarefas.');
        }
        $tasks = $user->tasks()->orderBy('created_at', 'desc')->get();

        Log::info('Listagem de tarefas acessada', ['user_id' => $user->id, 'quantidade' => $tasks->count()]);

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate
        ([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'due_date' => ['nullable', 'date', 'after_or_equal:today'],
            'priority' => ['nullable' , 'string', 'in:Alta,Media,Baixa'],
        ], [
            'title.required' => 'O título é obrigatório.',
            'title.max' => 'O título não pode exceder 255 caracteres.',
            'description.max' => 'A descrição não pode exceder 500 caracteres.',
            'due_date.date' => 'A data limite deve ser uma data válida.',
            'due_data.after_or_equal' => 'A data limite deve ser uma data futura ou igual a hoje.',
            'priority.in' => 'A prioridade deve ser uma das seguintes opções: Alta, Media, Baixa.',
        ]);

        $task = Auth::user()->tasks()->create($validatedData);

        Log::info('Tarefa criada', ['user_id' => Auth::id(), 'id' => $task->id, 'title' => $task->title]);


        return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso!');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        if (Auth::id() !== $task->user_id) {
            return redirect()->route('tasks.index')->with('error', 'Você não tem permissão para excluir esta tarefa.');
        }
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tarefa excluída com sucesso!');
    }

    public function edit($id) {
    $task = Task::findOrFail($id);

    if (Auth::id() !== $task->user_id) {
        return redirect()->route('tasks.index')->with('error', 'Você não tem permissão para editar esta tarefa.');
    }

    return view('tasks.edit', compact('task'));
}

public function update(Request $request, $id) {
    $task = Task::findOrFail($id);

    if (Auth::id() !== $task->user_id) {
        return redirect()->route('tasks.index')->with('error', 'Você não tem permissão para editar esta tarefa.');
    }
    // Validação dos dados
    $validatedData = $request->validate([
        'title' => ['sometimes', 'required', 'string', 'max:255'],
        'description' => ['nullable', 'string', 'max:500'],
        'due_date' => ['nullable', 'date', 'after_or_equal:today'],
        'priority' => ['nullable', 'string', 'in:Alta,Media,Baixa'],
    ], [
        'title.required' => 'O título é obrigatório.',
        'title.max' => 'O título não pode exceder 255 caracteres.',
        'description.max' => 'A descrição não pode exceder 500 caracteres.',
        'due_date.after_or_equal' => 'A data de vencimento deve ser uma data futura ou igual a hoje.',
        'priority.in' => 'A prioridade deve ser uma das seguintes opções: Alta, Media, Baixa.',
    ]);

    if (!$request->filled('due_date'))
    {
        $validatedData['due_date'] = null;
    }

    if (!$request->filled('priority'))
    {
        $validatedData['priority'] = null;
    }
    $task->update($validatedData);
    return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada com sucesso!');
}



}
