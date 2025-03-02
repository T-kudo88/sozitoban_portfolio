<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

// 🔹 認証不要のAPIエンドポイント
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// 🔹 Sanctum 認証が必要なエンドポイント
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tasks', [TaskController::class, 'apiIndex'])->name('tasks.list');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    // 🔹 `/user` も認証済みユーザーのみアクセス可能
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
});

// 🛑 🔹 この二重定義は削除！
