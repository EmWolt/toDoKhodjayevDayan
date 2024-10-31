<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $userId = auth()->id();

        $tasks = Task::where('user_id', $userId);

        if ($request->has('completed') && $request->has('not_completed')) {
        } elseif ($request->has('completed')) {
            $tasks->where('completed', true);
        } elseif ($request->has('not_completed')) {
            $tasks->where('completed', false);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;

            if (is_numeric($search)) {
                $tasks->where('id', $search);
            } else {
                $tasks->where('title', 'LIKE', '%' . $search . '%');
            }
        }

        $tasks = $tasks->get();

        return view('tasks.index', compact('tasks'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => ['required', 'max:255'],
            'description' => ['nullable', 'max:255'],
            'completed'   => ['nullable', 'boolean'],
        ]);

        $user = Auth::user();

        $task = Task::create([
            'title'       => $request->title,
            'description' => $request->description,
            'completed'   => $request->completed ?? false,
            'user_id'     => $user->id,
        ]);

        return redirect(route('tasks.index'));
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
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title'       => ['required', 'max:255'],
            'description' => ['nullable', 'max:255'],
            'completed'   => ['nullable', 'boolean'],
        ]);

        $task->update([
            'title'       => $request->title,
            'description' => $request->description,
            'completed'   => $request->completed ?? false,
        ]);

        return redirect(route('tasks.index'));
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
