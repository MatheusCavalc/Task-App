<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Models\Task;
use Illuminate\Http\Request;

class SubtaskController extends Controller
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
            'task_id' => 'required',
            'name' => 'required|max:255',
            'status' => 'required',
        ]);

        //dd($data);

        $subtask = Subtask::create($data);

        return response()->json($subtask, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subtask $subtask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subtask $subtask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subtask $subtask)
    {
        $request->request->add(['user_id' => auth()->user()->id]);

        $data = $request->validate([
            'user_id' => 'required',
            'task_id' => 'required',
            'name' => 'required|max:255',
            'status' => 'required',
        ]);

        $subtask->update($data);

        //return response()->json($subtask, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subtask $subtask)
    {
        $subtask->delete();
    }
}
