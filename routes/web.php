<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;
use App\Services\SlackNotifier;

// 🏠 ホーム画面
Route::get('/', fn() => Inertia::render('Home'));

Route::get('/{any}', function () {
    return Inertia::render('Home'); // または必要な初期ページ
})->where('any', '.*');

// 登録・編集ページ
Route::get('/register', fn() => Inertia::render('Register'));
Route::get('/users/edit', fn() => Inertia::render('EditUser'));
Route::get('/history', fn() => Inertia::render('History'));

// 認証（もし使ってるなら）
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Slack通知テスト（任意）
Route::get('/test-slack', function () {
    SlackNotifier::send('✅ Slack通知テスト：掃除当番アプリから送信されました！');
    return '通知送信しました！';
});
