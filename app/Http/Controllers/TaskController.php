<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->request->add(['user_id' => auth()->user()->id]);

        $data = $request->validate([
            'user_id' => 'required',
            'name' => 'required|max:255',
            'category_id' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        Task::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->request->add(['user_id' => auth()->user()->id]);

        $data = $request->validate([
            'user_id' => 'required',
            'name' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
            'category_id' => 'required',
        ]);

        $task->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
    }

    public function addAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
            'task' => 'required|exists:tasks,id',
        ]);

        $user = User::where('email', $request->email)->first();
        $task = Task::where('id', $request->task)->first();

        $is_admin = TaskUser::where('task_id', $request->task)->where('user_id', $user->id)->exists();

        if ($is_admin) {
            return response()->json([
                'message' => 'Is admin'
            ], 200);
        } else if($user) {
            TaskUser::create([
                'task_id' => $task->id,
                'user_id' => $user->id
            ]);

            return response()->json([
                'message' => 'New admin add'
            ], 200);
        }
    }
}
