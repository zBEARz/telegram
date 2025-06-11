<?php

namespace App\Http\Controllers;

use App\Services\FormService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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

    public function submit(Request $request)
    {
        try {
            $this->formService->validateAndSubmit($request);

            return response()->json([
                'message' => 'Сообщение успешно отправлено'
            ]);
        } catch (ValidationException $e) {
            $this->formService->sendNotification($request, true, 'Ошибка: ' . $e->getMessage());

            return response()->json([
                'message' => 'Ошибка',
                'errors' => $e->errors()
            ], 500);
        } catch (Exception $e) {
            $this->formService->sendNotification($request, true, 'Системная ошибка: ' . $e->getMessage());

            return response()->json([
                'message' => 'Произошла ошибка',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
