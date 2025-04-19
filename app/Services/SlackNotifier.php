<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SlackNotifier
{
    public static function send(string $message): void
    {
        $url = config('services.slack.webhook_url');

        if (!$url) {
            logger()->error('Slack Webhook URLが設定されていません。');
            return;
        }

        Http::post($url, [
            'text' => $message
        ]);
    }
}
