<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // 🔹 ユーザー一覧取得
    public function index()
    {
        return User::whereNull('deleted_at')->get(); // 論理削除対応
    }

    // 🔹 ユーザー登録
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|string|max:30',
            'name'        => 'required|string|max:50',
            'email'       => 'required|email|unique:users,email',
            'position'    => 'required|string|max:50',
            'password'    => 'required|string|min:6', //
        ]);

        User::create([
            'employee_id' => $validated['employee_id'], // ← これを追加
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'position'    => $validated['position'],
            'password'    => bcrypt($validated['password']), // ← bcrypt 忘れずに！
        ]);

        return response()->json(['message' => '登録完了'], 201);
    }

    // 🔹 ユーザー削除
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'ユーザーを削除しました']);
    }


    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!is_array($ids)) {
            return response()->json(['error' => 'Invalid data'], 422);
        }

        User::whereIn('id', $ids)->update(['deleted_at' => now()]);

        return response()->json(['message' => '削除完了']);
    }
}
