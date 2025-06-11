<?php

namespace App\Services;

use App\Notifications\ExampleNotification;
use Illuminate\Support\Facades\Notification;
use Exception;

class TelegramService
{
    public function sendMessage($data, bool $isError = false, string $errorMessage = null)
    {
        $chatId = config('services.telegram-bot-api.chat_id');

        if (!$chatId) {
            throw new Exception('Telegram chat ID не настроен');
        }

        try {
            Notification::route('telegram', $chatId)
                ->notify(new ExampleNotification($data, $isError, $errorMessage));
        } catch (Exception $e) {
            throw new Exception('Ошибка отправки в Telegram: ' . $e->getMessage());
        }
    }
}
