<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SlackNotifier;

class SendCleaningReminder extends Command
{
    protected $signature = 'notify:cleaning';
    protected $description = '毎週金曜日 13:50 に掃除当番をSlackに通知する';

    public function handle()
    {
        SlackNotifier::send('🧹 掃除の時間です！担当者は掃除場所を確認してください。');
        $this->info('Slackに通知しました！');
    }
}
