<?php

namespace App\Http\Controllers;

use App\Enums\SubtaskStatusEnum;
use App\Enums\TaskStatusEnum;
use App\Events\TaskUpdate;
use App\Models\Category;
use App\Models\Subtask;
use App\Models\Task;
use App\Models\TaskUser;
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
        return Inertia::render('App/Index');
    }

    public function myTasks()
    {
        $tasks = Task::with('subtasks', 'category')->where('user_id', auth()->user()->id)->get()->map(function ($task) {
            $task->formatted_created_at = $task->created_at->format('d M');
            return $task;
        });
        $categories = Category::where('user_id', auth()->user()->id)->get();
        $task_status = TaskStatusEnum::cases();

        $teams_tasks = TaskUser::with('task', 'task.subtasks', 'task.category')->where('user_id', auth()->user()->id)->get()->map(function ($task) {
            $task->formatted_created_at = $task->created_at->format('d M');
            return $task;
        });;

        return Inertia::render('App/MyTasks', compact('tasks', 'teams_tasks', 'categories', 'task_status'));
    }

    public function detailsTask($id)
    {
        $task = Task::with('subtasks', 'category')->find($id);
        $created_on = $task->created_at->format('d M');
        $auth_id = auth()->user()->id;

        return Inertia::render('App/Details', compact('task', 'created_on', 'auth_id'));
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
            'status' => ['required'],
            'task' => ['required'],
            'dropResult' => ['required'],
            'cardData' => ['required']
        ]);

        $options = [
            'inProgressArray' => SubtaskStatusEnum::In_Progress->value,
            'waitingArray' => SubtaskStatusEnum::Waiting->value,
        ];

        $status = $options[$request->status] ?? SubtaskStatusEnum::Finished->value;

        Subtask::where('id', $request->subtaskId)->update(['status' => $status]);

        event(new TaskUpdate(
            $request->task,
            $request->subtaskId,
            $request->status,
            $request->dropResult,
            $request->cardData,

            $request->draggingCard,

            auth()->user()->id
        ));
    }

    public function adminTask(Task $task)
    {
        if($task->user_id == auth()->user()->id) {
            return Inertia::render('App/Task/Admin', compact('task'));
        }

        return response('Not Found', 404);
    }
}
