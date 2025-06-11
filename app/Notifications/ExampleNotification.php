<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class ExampleNotification extends Notification
{
    use Queueable;

    protected $data;
    protected $isError;
    protected $errorMessage;

    /**
     * Create a new notification instance.
     */
    public function __construct($data, bool $isError = false, string $errorMessage = null)
    {
        $this->data = $data;
        $this->isError = $isError;
        $this->errorMessage = $errorMessage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return [TelegramChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toTelegram($notifiable)
    {
        $message = $this->isError
            ? $this->formatErrorMessage()
            : $this->formatSuccessMessage();

        return TelegramMessage::create()->content($message);
    }

    protected function formatErrorMessage(): string
    {
        return "❌ ОШИБКА В СИСТЕМЕ\n\n" .
            "Детали ошибки: {$this->errorMessage}\n\n" .
            "Данные запроса:\n" .
            "Имя: {$this->data->name}\n" .
            "Email: {$this->data->email}\n" .
            "Сообщение: {$this->data->message}";
    }

    protected function formatSuccessMessage(): string
    {
        return "✅ Новое сообщение\n\n" .
            "Имя: {$this->data->name}\n" .
            "Email: {$this->data->email}\n" .
            "Сообщение: {$this->data->message}";
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
