<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\TaskHistory;

// ✅ 全ユーザー一覧
Route::get('/users', function () {
    return User::all();
});

// ✅ タスク一覧
Route::get('/tasks', function () {
    return Task::with('user')->get();
});

// ✅ タスク作成
Route::post('/tasks', function (Request $request) {
    return Task::create($request->all());
});

Route::post('/tasks/shuffle', function () {
    $tasks = Task::all()->shuffle(); // Laravelコレクションの shuffle()

    // 各タスクに順番に割り振る（例：担当席を再設定するなど）
    foreach ($tasks as $index => $task) {
        $task->seat = '席' . ($index + 1); // 例： 席1、席2...
        $task->save();
    }

    return response()->json(['message' => 'シャッフル完了']);
});

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
