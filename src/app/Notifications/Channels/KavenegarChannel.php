<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KavenegarChannel
{
    /**
     * Send the given notification.
     */
    public function send($notifiable, Notification $notification): void
    {
        if (! method_exists($notification, 'toKavenegar')) {
            return;
        }

        $message = $notification->toKavenegar($notifiable);

        if (! $message) {
            return;
        }

        $config = config('kavenegar');
        $token = $config['token'] ?? '';
        $baseUrl = rtrim($config['base_url'] ?? '', '/');
        $endpoint = $config['lookup_endpoint'] ?? 'verify/lookup.json';
        $template = $message->template ?? $config['template'] ?? 'auth';
        $receptor = $message->receptor ?? $notifiable->routeNotificationFor('kavenegar');
        $payload = [
            'receptor' => $receptor,
            'token' => $message->token,
            'template' => $template,
        ];

        if (empty($payload['receptor']) || empty($payload['token']) || empty($token) || empty($baseUrl)) {
            Log::warning('KavenegarChannel skipped send due to missing configuration.', [
                'receptor' => $payload['receptor'],
                'has_token' => ! empty($token),
                'has_base_url' => ! empty($baseUrl),
            ]);

            return;
        }

        $url = "{$baseUrl}/{$token}/{$endpoint}";

        try {
            $response = Http::acceptJson()->get($url, $payload);

            if (! $response->ok()) {
                Log::warning('KavenegarChannel unexpected response.', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        } catch (\Throwable $exception) {
            Log::error('KavenegarChannel failed to send message: ' . $exception->getMessage(), [
                'exception' => $exception,
            ]);
        }
    }
}
