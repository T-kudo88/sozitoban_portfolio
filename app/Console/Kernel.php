<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('cleaning:notify')->weeklyOn(5, '13:50'); // 毎週金曜13:50に実行
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
    }
}
