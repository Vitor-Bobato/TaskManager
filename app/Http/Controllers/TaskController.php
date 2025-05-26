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
        $tasks = Task::where('user_id', Auth::id())->get();

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
            'priority' => 'required|in:Alta,Média,Baixa',
        ]);

//        $data = $request->all();
//        if (empty($data['due_date'])) {
//            $data['due_date'] = null;
//        }
//
//        $task = Task::create($data);
//
//        Log::info('Tarefa criada', ['id' => $task->id, 'title' => $task->title]);

        $validated['user_id'] = Auth::id();

        Task::create($validated);


        return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso!');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tarefa excluída com sucesso!');
    }

}
