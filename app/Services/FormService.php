<?php

namespace App\Services;

use App\Http\Requests\FormSubmitRequest;

class FormService
{
    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function handle(FormSubmitRequest $request)
    {
        $this->telegramService->sendMessage($request);
    }

    public function handleError($request, string $errorMessage)
    {
        $this->telegramService->sendMessage($request, true, $errorMessage);
    }
}
