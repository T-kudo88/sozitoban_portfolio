<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TaskController extends Controller
{
    // 🟢 Web版 (Vue.js)
    public function index()
    {
        $tasks = Task::with('user')->get();
        return Inertia::render('Tasks/Index', ['tasks' => $tasks]);
    }

    // 🟢 API版 (JSON)
    public function apiIndex()
    {
        return response()->json(Task::with('user')->get());
    }

    // 🟢 新しい掃除当番を追加 (POST /api/tasks)
    public function store(Request $request)
    {
        $request->validate([
            'area' => 'required|string|max:255',
        ]);

        $task = Task::create([
            'user_id' => Auth::id(), // 現在ログイン中のユーザー
            'area' => $request->area,
        ]);

        return response()->json($task, 201);
    }

    // 🟢 掃除当番を更新 (PUT /api/tasks/{id})
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'area' => 'required|string|max:255',
        ]);

        $task->update(['area' => $request->area]);

        return response()->json($task);
    }

    // 🟢 掃除当番を削除 (DELETE /api/tasks/{id})
    public function destroy(Task $task)
    {
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted'], 200);
    }
}
