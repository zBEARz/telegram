<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormSubmitRequest;
use App\Services\FormService;
use Exception;

class FormController extends Controller
{
    protected $formService;

    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }

    public function showForm()
    {
        return view('form');
    }

    public function submit(FormSubmitRequest $request)
    {
        try {
            $this->formService->handle($request);
            return response()->json(['message' => 'Сообщение успешно отправлено']);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Произошла ошибка',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
