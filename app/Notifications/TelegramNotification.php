<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use WeStacks\TeleBot\Laravel\TelegramNotification;

class TelegramNotification extends Notification
{
    public function via($notifiable)
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        return (new TelegramNotification)->bot('bot')
            ->sendMessage([
                'chat_id' => $notifiable->telegram_chat_id,
                'text'    => 'Hello, from Laravel\'s notifications!'
            ])
            ->sendMessage([
                'chat_id' => $notifiable->telegram_chat_id,
                'text'    => 'Second message'
            ]);
    }
}