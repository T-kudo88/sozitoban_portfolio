<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskHistoryController;

// 🔹 認証不要のエンドポイント
Route::prefix('/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('api.login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('api.logout');
});

// 🔹 認証が必要なエンドポイント
Route::middleware('auth:sanctum')->group(function () {

    // 🔹 タスク関連エンドポイント
    Route::prefix('/tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('tasks.list');
        Route::post('/', [TaskController::class, 'store'])->name('tasks.store');
        Route::put('/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    });

    // 🔹 ユーザー関連エンドポイント（今後の拡張用）
    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.list');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // 🔹 清掃履歴関連
    Route::prefix('/task-histories')->group(function () {
        Route::get('/', [TaskHistoryController::class, 'index'])->name('task-histories.index');
        Route::post('/', [TaskHistoryController::class, 'store'])->name('task-histories.store');
    });

    // 🔹 認証済みユーザーの情報取得
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    })->name('user.profile');
});
