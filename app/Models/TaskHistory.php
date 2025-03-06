<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_id',
        'completed_at',
        'remarks',
    ];

    public $timestamps = false; // 🔹 これを追加することで `created_at` & `updated_at` を無効化

    // ユーザーとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // タスクとのリレーション
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
