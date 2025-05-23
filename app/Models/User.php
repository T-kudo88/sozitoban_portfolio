<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes; // ← これを追加


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['employee_id', 'name', 'email', 'position', 'password'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [ // 🔹 `protected function casts()` → `protected $casts = [...]` に修正
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function taskHistories()
    {
        return $this->hasMany(TaskHistory::class);
    }
}
