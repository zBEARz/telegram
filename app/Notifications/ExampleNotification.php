<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use Exception;

class ExampleNotification extends Notification
{
    use Queueable;

    protected $request;
    protected $isError;
    protected $errorMessage;

    /**
     * Create a new notification instance.
     */
    public function __construct($request, $isError = false, $errorMessage = null)
    {
        $this->request = $request;
        $this->isError = $isError;
        $this->errorMessage = $errorMessage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [TelegramChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toTelegram($notifiable)
    {
        try {
            if ($this->isError) {
                $message = "ОШИБКА В СИСТЕМЕ\n\n";
                $message .= "Детали ошибки: {$this->errorMessage}\n\n";
                $message .= "Данные запроса:\n";
                $message .= "Имя: {$this->request->name}\n";
                $message .= "Email: {$this->request->email}\n";
                $message .= "Сообщение: {$this->request->message}";
            } else {
                $message = "Новое сообщение\n\n";
                $message .= "Имя: {$this->request->name}\n";
                $message .= "Email: {$this->request->email}\n";
                $message .= "Сообщение: {$this->request->message}";
            }

            return TelegramMessage::create()
                ->content($message);
        } catch (Exception $ex) {
            Log::error($ex);
        }
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
