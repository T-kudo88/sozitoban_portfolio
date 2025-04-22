<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskHistory;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskHistoryController;
use App\Http\Controllers\TaskController;

// ✅ ユーザー関連
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::post('/users/delete', [UserController::class, 'bulkDelete']);

// ✅ タスク関連
// routes/api.php

Route::get('/tasks', function () {
    $users = \App\Models\User::whereNull('deleted_at')->orderBy('id')->get();
    $tasks = \App\Models\Task::all()->groupBy('user_id');

    $result = $users->map(function ($user) use ($tasks) {
        $taskList = $tasks->get($user->id);

        $task = $taskList?->first();

        return [
            'user' => $user,
            'seat' => $task->seat ?? '',
            'method' => $task->method ?? '',
            'tool' => $task->tool ?? '',
        ];
    });

    return response()->json($result);
});

Route::post('/tasks', function (Request $request) {
    return Task::create($request->all());
});


Route::post('/tasks/shuffle', [TaskController::class, 'shuffle']);
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

    Route::get('/task-histories', [TaskHistoryController::class, 'index']);
    Route::post('/task-histories', [TaskHistoryController::class, 'store']);

    return response()->json($history);
});
