<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TodoResource;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index()
    {
        // Implement logic to get all todos for the authenticated user
        $todos = Todo::where('user_id', auth()->id())->get();
        return response()->json(['todos' => TodoResource::collection($todos)], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            // Add other validation rules based on your requirements
        ]);

        $todo = Todo::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            // Add other fields based on your ToDo model
        ]);

        return response()->json(['message' => 'Todo created', 'todo' => new TodoResource($todo)], 201);
    }

    public function show($todo_id)
    {
        // Implement logic to get a specific todo by ID for the authenticated user
        $todo = Todo::where('user_id', auth()->id())->find($todo_id);

        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }

        return response()->json(['todo' => new TodoResource($todo)], 200);
    }

    public function update(Request $request, $todo_id)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            // Add other validation rules based on your requirements
        ]);

        $todo = Todo::where('user_id', auth()->id())->find($todo_id);

        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }

        $todo->update([
            'title' => $request->title,
            'description' => $request->description,
            // Update other fields based on your ToDo model
        ]);

        return response()->json(['message' => 'Todo updated', 'todo' => new TodoResource($todo)], 200);
    }

    public function destroy($todo_id)
    {
        // Implement logic to delete a specific todo by ID for the authenticated user
        $todo = Todo::where('user_id', auth()->id())->find($todo_id);

        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }

        $todo->delete();

        return response()->json(['message' => 'Todo deleted', 'todo' => new TodoResource($todo)], 200);
    }
}
