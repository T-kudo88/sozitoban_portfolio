<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Collection;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'seat',
        'method',
        'tool',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function shuffleAndAssignTasks()
    {
        $users = \App\Models\User::whereNull('deleted_at')->orderBy('id')->get();

        $cleaningSets = [
            ['seat' => '1Fトイレ', 'method' => 'モップがけ', 'tool' => 'モップ'],
            ['seat' => '2F給湯室', 'method' => '拭き掃除', 'tool' => '雑巾'],
            // ...必要な掃除セットを追加
        ];

        // tasks テーブルを空に
        self::query()->delete();

        // 掃除セットをシャッフル
        $shuffledSets = collect($cleaningSets)->shuffle();

        foreach ($users as $i => $user) {
            if (!isset($shuffledSets[$i])) break;

            self::create([
                'user_id' => $user->id,
                'seat'    => $shuffledSets[$i]['seat'],
                'method'  => $shuffledSets[$i]['method'],
                'tool'    => $shuffledSets[$i]['tool'],
            ]);
        }

        return true;
    }
    public static function shuffleAndAssign(): array
    {
        try {
            $users = User::whereNull('deleted_at')->orderBy('id')->get();

            $cleaningSets = [
                ['seat' => '1Fトイレ', 'method' => 'モップがけ', 'tool' => 'モップ'],
                ['seat' => '2F給湯室', 'method' => '拭き掃除', 'tool' => '雑巾'],
                // ... 残りの掃除セットも省略せずに記載
                ['seat' => '休憩室', 'method' => 'モップがけ', 'tool' => 'モップ'],
            ];

            self::query()->delete(); // 既存削除
            $shuffledSets = collect($cleaningSets)->shuffle();

            foreach ($users as $i => $user) {
                if (!isset($shuffledSets[$i])) break;

                self::create([
                    'user_id' => $user->id,
                    'seat'    => $shuffledSets[$i]['seat'],
                    'method'  => $shuffledSets[$i]['method'],
                    'tool'    => $shuffledSets[$i]['tool'],
                ]);
            }

            return ['message' => 'シャッフル完了'];
        } catch (\Throwable $e) {
            Log::error('シャッフル失敗: ' . $e->getMessage());
            throw $e;
        }
    }
}
