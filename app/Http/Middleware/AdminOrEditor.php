<?php

namespace App\Http\Middleware;

use App\Models\Task;
use App\Models\TaskUser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOrEditor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $taskId = $request->route('task');

        if ($this->userHasPermission($taskId)) {
            return $next($request);
        }

        abort(403, 'Você não tem permissão para acessar esta tarefa.');
    }

    private function userHasPermission($taskId)
    {
        $taskAdmin = Task::where('id', $taskId)
            ->where('user_id', auth()->id())
            ->exists();

        $taskEditor = TaskUser::where('task_id', $taskId)
            ->where('user_id', auth()->id())
            ->exists();

        return $taskAdmin || $taskEditor;
    }
}
