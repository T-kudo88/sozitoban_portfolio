<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskHistory;
use App\Http\Controllers\UserController;

// ✅ ユーザー関連
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::post('/users/delete', [UserController::class, 'bulkDelete']);

// ✅ タスク関連
Route::get('/tasks', function () {
    return Task::with('user')->get();
});

Route::post('/tasks', function (Request $request) {
    return Task::create($request->all());
});

Route::post('/tasks/shuffle', function () {
    $tasks = Task::all()->shuffle();
    foreach ($tasks as $index => $task) {
        $task->seat = '席' . ($index + 1);
        $task->save();
    }
    return response()->json(['message' => 'シャッフル完了']);
});

// ✅ タスク履歴取得（これが必要！）
Route::get('/task-histories', function () {
    return TaskHistory::with(['user', 'task'])->orderBy('created_at', 'desc')->get();
});

// ✅ タスク履歴登録
Route::post('/task-histories', function (Request $request) {
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'task_id' => 'required|exists:tasks,id',
    ]);

    $history = TaskHistory::create([
        'user_id' => $validated['user_id'],
        'task_id' => $validated['task_id'],
        'completed_at' => now(),
    ]);

    return response()->json($history);
});
