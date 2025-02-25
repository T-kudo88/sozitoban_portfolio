<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// ✅ 認証なしで API にアクセス可能（テスト用）
Route::apiResource('tasks', TaskController::class);
