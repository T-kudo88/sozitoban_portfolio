<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;

Route::get('/users/edit', fn() => Inertia::render('EditUser'))->name('users.edit');
Route::get('/register', fn() => Inertia::render('Register'))->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// 最後にワイルドカードを定義（全てにマッチするので一番下）
Route::get('/{any?}', function () {
    return Inertia::render('Home');
})->where('any', '.*');
