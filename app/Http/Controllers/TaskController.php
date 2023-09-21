<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{


    public function index(Request $request)
    {
        // $tasks = Task::all();
        $tasks = Task::orderBy('id', 'desc')->get();
        return view('welcome', compact('tasks'));
        // return view('welcome');
    }

    public function save(Request $request)
{

    // Validate the form data
    $validatedData = $request->validate([
        'task' => 'required|string|max:255',
    ]);
    
    $task = new Task([
        'task' => $validatedData['task'],
        // Add other fields here if needed
    ]);
    $task->save();
    return response()->json(['message' => 'Form submitted successfully', 'data' => $task]);
}

        public function delete($id)
        {
            // Find the task by its ID
            $task = Task::find($id);
            if (!$task) {
                return response()->json(['error' => 'Task not found']);
            }
            // Delete the task
            $task->delete();
            return response()->json(['success', 'Task deleted successfully']);
        }

}
