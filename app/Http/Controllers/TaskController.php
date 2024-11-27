<?php

namespace App\Http\Controllers;


use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // create
    public function create(Request $request)
    {
        $task = Task::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'user_id' => $request->user()->id,
        ]);
        return response()->json(['message' => 'Task created successfully']);
    }

    // find
    public function index(Request $request)
    {
        $tasks = Task::where('user_id', $request->user()->id)->get();
        if ($tasks->isEmpty()) {
        return response()->json(['message' => 'No tasks found for the user']);
        }
        return response()->json(['tasks' => $tasks]);
    }

    // update
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task || $task->user_id != $request->user()->id) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        $task->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        return response()->json(['message' => 'Task updated successfully']);
    }

    // delete
    public function destroy(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task || $task->user_id != $request->user()->id) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}

