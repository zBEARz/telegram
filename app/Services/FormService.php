<?php

namespace App\Services;

use App\Notifications\ExampleNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class FormService
{
    public function validateAndSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        $this->sendNotification($request);
    }

    public function sendNotification(Request $request, bool $isError = false, string $errorMessage = null)
    {
        Notification::route('telegram', '1681133711')
            ->notify(new ExampleNotification($request, $isError, $errorMessage));
    }
}
