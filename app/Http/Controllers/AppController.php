<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppController extends Controller
{
    public function index()
    {
        return Inertia::render('App/Index', [
            'user' => User::with('tasks')->find(auth()->user()->id)
        ]);
    }

    public function details($id)
    {
        return Inertia::render('App/Details', [
            'task' => Task::with('subtasks')->find($id)
        ]);
    }

    public function updateStatus(Request $request)
    {
        request()->validate([
            'subtaskId' => ['required'], //, 'exists:card_lists,id'
            'status' => ['required']
        ]);

        $options = [
            'emExecucaoArray' => 'Em execucao',
            'aguardandoArray' => 'Aguardando',
        ];

        $status = $options[$request->status] ?? 'Concluida';

        Subtask::where('id', $request->subtaskId)->update(['status' => $status]);
    }
}
