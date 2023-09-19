<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatusEnum;
use App\Models\Category;
use App\Models\Subtask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppController extends Controller
{
    public function __construct(LayoutController $layoutController)
    {
        $this->middleware(function ($request, $next) use ($layoutController) {
            $layoutController->shareCommonData();
            return $next($request);
        });
    }

    public function index()
    {
        //$status = TaskStatusEnum::Waiting->value;
        //dd(TaskStatusEnum::cases());

        return Inertia::render('App/Index', [
            'tasks' => Task::with('subtasks', 'category')->where('user_id', auth()->user()->id)->get(),
            'categories' => Category::where('user_id', auth()->user()->id)->get(),
            'task_status' => TaskStatusEnum::cases(),
        ]);
    }

    public function detailsTask($id)
    {
        return Inertia::render('App/Details', [
            'task' => Task::with('subtasks')->find($id)
        ]);
    }

    public function detailsCategory($id)
    {
        return Inertia::render('App/DetailsCategory', [
            'tasks' => Task::with('subtasks', 'category')->where('category_id', $id)->get()
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
