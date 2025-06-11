<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormSubmitRequest;
use App\Services\TelegramService;
use Exception;

class FormController extends Controller
{
    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function showForm()
    {
        return view('form');
    }

    public function submit(FormSubmitRequest $request)
    {
        try {
            $this->telegramService->sendMessage($request);
            return response()->json(['message' => 'Сообщение успешно отправлено']);
        } catch (Exception $e) {
            $this->telegramService->sendMessage($request, true, $e->getMessage());
            return response()->json([
                'message' => 'Произошла ошибка',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
