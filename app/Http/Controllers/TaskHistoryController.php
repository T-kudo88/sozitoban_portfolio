<?php

namespace App\Http\Controllers;

use App\Models\TaskHistory;
use App\Http\Resources\UserTaskHistoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskHistoryController extends Controller
{
    /**
     * 履歴一覧取得（ISO形式で返す）
     */
    public function index()
    {
        $histories = TaskHistory::with(['user', 'task'])
            ->orderBy('created_at', 'desc')
            ->get();

        return UserTaskHistoryResource::collection($histories);
    }

    /**
     * 新しい履歴の保存
     */
    public function store(Request $request)
    {
        Log::info('🌟 TaskHistory storeリクエスト到達', [
            'user_id' => auth()->id(),
            'request_data' => $request->all()
        ]);

        $validated = $request->validate([
            'task_id'     => 'required|exists:tasks,id',
            'remarks'     => 'nullable|string|max:255',
            'area'        => 'required|string|max:255',
            'cleaned_at'  => 'nullable|date',
        ]);

        $history = TaskHistory::create([
            'user_id'      => auth()->id(),
            'task_id'      => $validated['task_id'],
            'area'         => $validated['area'],
            'remarks'      => $validated['remarks'] ?? null,
            'completed_at' => $validated['cleaned_at'] ?? now(),
        ]);

        return response()->json($history, 201);
    }

    public function show(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
