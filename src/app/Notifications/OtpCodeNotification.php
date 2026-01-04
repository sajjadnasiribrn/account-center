<?php

namespace App\Notifications;

use App\Notifications\Channels\KavenegarChannel;
use App\Notifications\Messages\KavenegarMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OtpCodeNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $code,
        public ?string $phone = null
    ) {
    }

    public function via(object $notifiable): array
    {
        return [KavenegarChannel::class];
    }

    public function toKavenegar($notifiable): KavenegarMessage
    {
        $template = config('kavenegar.template', 'auth');
        $targetPhone = $this->phone ?? $notifiable->routeNotificationFor('kavenegar');

        return KavenegarMessage::lookup($this->code)
            ->to($targetPhone)
            ->usingTemplate($template);
    }
}
