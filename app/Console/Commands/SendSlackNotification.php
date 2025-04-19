<?php

// app/Console/Commands/SendSlackNotification.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class SendSlackNotification extends Command
{
    protected $signature = 'notify:slack';
    protected $description = 'Slackに掃除開始通知を送信します';

    public function handle()
    {
        $now = Carbon::now();

        // ✅ 毎週金曜日の13:50にのみ実行
        if (!$now->isFriday() || $now->format('H:i') !== '13:50') {
            $this->info('現在は金曜日の13:50ではないため、Slack通知はスキップされました。');
            return;
        }

        $webhookUrl = config('services.slack.webhook_url');

        if (!$webhookUrl) {
            $this->error('Slack Webhook URL が設定されていません！');
            return;
        }

        Http::post($webhookUrl, [
            'text' => '🧹 掃除の時間です！担当者は掃除を始めましょう！',
        ]);

        $this->info('Slackに通知を送信しました。');
    }
}
