<?php

namespace App\Services;

use App\Notifications\ExampleNotification;
use Illuminate\Support\Facades\Notification;

class TelegramService
{
    public function sendMessage($data, bool $isError = false, string $errorMessage = null)
    {
        $chatId = config('services.telegram-bot-api.chat_id');

        Notification::route('telegram', $chatId)
            ->notify(new ExampleNotification($data, $isError, $errorMessage));
    }
}
