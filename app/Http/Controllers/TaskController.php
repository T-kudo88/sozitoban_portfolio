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
        $validated = $request->validate([
            'area' => 'required|string|max:255',
        ]);

        $task = Task::create([
            // 'user_id' => Auth::id(),
            'user_id' => 1, // 👈 仮のユーザーID
            'area' => $validated['area'],
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
    public function shuffleAndAssign(Request $request)
    {
        $users = \App\Models\User::all();
        $tasks = Task::all();

        if ($users->count() !== $tasks->count()) {
            return response()->json(['error' => 'ユーザー数とタスク数が一致していません'], 422);
        }

        $shuffledUsers = $users->shuffle();

        foreach ($tasks as $index => $task) {
            $task->user_id = $shuffledUsers[$index]->id;
            $task->save();
        }

        return response()->json(['message' => 'シャッフル完了', 'tasks' => Task::with('user')->get()]);
    }
}
