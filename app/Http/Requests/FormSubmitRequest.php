<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\TelegramService;

class FormSubmitRequest extends FormRequest
{
    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
        parent::__construct();
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя обязательно для заполнения',
            'name.string' => 'Имя должно быть текстом',
            'name.max' => 'Имя не должно превышать 255 символов',
            'email.required' => 'Email обязателен для заполнения',
            'email.email' => 'Введите корректный email',
            'email.max' => 'Email не должен превышать 255 символов',
            'message.required' => 'Сообщение обязательно для заполнения',
            'message.string' => 'Сообщение должно быть текстом',
            'message.max' => 'Сообщение не должно превышать 1000 символов'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Отправляем ошибки в Telegram
        $this->telegramService->sendMessage(
            $this,
            true,
            'Ошибка валидации: ' . json_encode($validator->errors()->all())
        );

        throw new ValidationException($validator);
    }
}
