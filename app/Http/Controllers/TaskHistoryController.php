<?php

namespace App\Http\Controllers;

use App\Models\TaskHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Task;

class TaskHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = auth()->id();
        $query = TaskHistory::with(['task', 'user'])->where('user_id', $userId);

        if ($request->has('area')) {
            $query->where('area', $request->input('area'));
        }

        return response()->json($query->orderBy('completed_at', 'desc')->get());
    }

    /**
     * Store a newly created resource in storage.
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
            'area'         => $validated['area'], // 🔹 追加
            'remarks'      => $validated['remarks'] ?? null,
            'completed_at' => $validated['cleaned_at'] ?? now(),
        ]);

        return response()->json($history, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
