<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Task::query()
            ->with('assignedUser:id,name')
            ->orderByDesc('id');

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $tasks = $query->paginate(10)->withQueryString();

        return response()->json([
            'message' => 'List of tasks',
            'data' => $tasks->items(),
            'meta' => [
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'per_page' => $tasks->perPage(),
                'total' => $tasks->total(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $task = Task::create($request->all());
        $task->load('assignedUser:id,name');

        return response()->json(['message' => 'Task created successfully', 'data' => $task], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::with('assignedUser:id,name')->findOrFail($id);

        return response()->json(['message' => 'Task found', 'data' => $task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());
        $task->load('assignedUser:id,name');

        return response()->json(['message' => 'Task updated successfully', 'data' => $task]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}
