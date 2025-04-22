<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Models\User;

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

    public static function shuffleAndAssign()
    {
        try {
            $users = User::whereNull('deleted_at')->orderBy('id')->get();

            $cleaningSets = [
                ['seat' => '1Fトイレ', 'method' => 'モップがけ', 'tool' => 'モップ'],
                ['seat' => '2F給湯室', 'method' => '拭き掃除', 'tool' => '雑巾'],
                ['seat' => '会議室A', 'method' => '掃き掃除', 'tool' => 'ほうき'],
                ['seat' => '会議室B', 'method' => '掃き掃除', 'tool' => 'ほうき'],
                ['seat' => '休憩室', 'method' => 'モップがけ', 'tool' => 'モップ'],
            ];

            self::query()->delete();

            foreach ($users as $user) {
                $randomSet = $cleaningSets[array_rand($cleaningSets)];

                self::create([
                    'user_id' => $user->id,
                    'seat'    => $randomSet['seat'],
                    'method'  => $randomSet['method'],
                    'tool'    => $randomSet['tool'],
                ]);
            }

            return ['message' => 'シャッフル完了'];
        } catch (\Throwable $e) {
            Log::error('シャッフル失敗: ' . $e->getMessage());
            throw $e;
        }
    }
}
