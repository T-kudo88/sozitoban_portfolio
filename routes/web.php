<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;

// 個別ルートは先に書く！
Route::get('/timer', function () {
    return Inertia::render('Timer');
});

Route::get('/users/edit', fn() => Inertia::render('EditUser'))->name('users.edit');
Route::get('/register', fn() => Inertia::render('Register'))->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// 最後にワイルドカード
Route::get('/{any?}', function () {
    return Inertia::render('Home');
})->where('any', '.*');
