<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // 🔹 ユーザー一覧取得
    public function index()
    {
        return response()->json(User::all());
    }

    // 🔹 ユーザー登録
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'position' => 'nullable|string|max:30',
            'password' => 'required|string|min:6'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'position' => $validated['position'] ?? '未設定',
            'password' => bcrypt($validated['password'])
        ]);

        return response()->json($user, 201);
    }

    // 🔹 ユーザー削除
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'ユーザーを削除しました']);
    }
}
