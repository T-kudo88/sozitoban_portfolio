<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendSlackNotification; // 忘れずにインポート！

class Kernel extends ConsoleKernel
{
    /**
     * Artisanコマンドのスケジュールを定義
     */
    protected function schedule(Schedule $schedule)
    {
        // 🕒 毎週金曜日の13:50に実行
        $schedule->command('notify:cleaning')
            ->everyMinute(); // テスト中は everyMinute、本番では下記へ変更
        // ->weeklyOn(5, '13:50');← 本番はこちら：毎週金曜13:50
    }

    /**
     * Artisanコマンドを登録
     */
    protected $commands = [
        SendSlackNotification::class,
    ];

    /**
     * コマンドファイルを読み込む
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
    }
}
