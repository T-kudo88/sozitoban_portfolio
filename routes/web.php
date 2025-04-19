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

Route::get('/{any}', function () {
    return view('app'); // resources/views/app.blade.php を返す（SPAのエントリ）
})->where('any', '.*');

// Laravel 側ではすべて app.blade.php を返す（SPAエントリ）
Route::view('/{any}', 'app')->where('any', '.*');
