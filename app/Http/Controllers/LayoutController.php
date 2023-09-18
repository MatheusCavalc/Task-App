<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LayoutController extends Controller
{
    public function shareCommonData()
    {
        $tasks = Task::where('user_id', Auth::id())->orderBy('id', 'desc')->take(3)->get();
        $categories = Category::where('user_id', Auth::id())->get();

        Inertia::share('userData', [
            'tasks' => $tasks,
            'categories' => $categories,
        ]);
    }
}
