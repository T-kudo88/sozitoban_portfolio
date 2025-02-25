<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TaskController extends Controller
{
    // 🟢 掃除当番リスト取得 (GET /tasks)
    public function index()
    {
        $tasks = Task::with('user')->get();
        return Inertia::render('Tasks/Index', ['tasks' => $tasks]);
    }

    // 🟢 新しい掃除当番を追加 (POST /tasks)
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

    // 🟢 掃除当番を更新 (PUT /tasks/{id})
    public function update(Request $request, Task $task)
    {
        // 🔹 他のユーザーのタスクを編集できないように制限
        if ($task->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'area' => 'required|string|max:255',
        ]);

        $task->update(['area' => $request->area]);

        return response()->json($task);
    }

    // 🟢 掃除当番を削除 (DELETE /tasks/{id})
    public function destroy(Task $task)
    {
        // 🔹 他のユーザーのタスクを削除できないように制限
        if ($task->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted']);
    }
}
