<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

// 🔹 フロントエンドの掃除当番管理画面（Vue の Tasks/Index.vue を表示）
Route::get('/', function () {
    return Inertia::render('Tasks/Index');
})->name('tasks.index');

// 🔹 `login` ルートの重複を防ぐため、`GET /login` のみ定義
Route::get('/login', function () {
    return Inertia::render('Auth/Login'); // Vue のログインページを表示
})->name('login');

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.view');
