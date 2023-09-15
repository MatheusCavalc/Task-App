<?php

namespace App\Http\Controllers;

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

    public function details()
    {
       // dd(Task::with('subtasks')->find(1));

        return Inertia::render('App/Details', [
            'task' => Task::with('subtasks')->find(1)
        ]);
    }
}
