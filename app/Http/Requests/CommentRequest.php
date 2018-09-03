<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validators = [];

        if (!Auth::check()) {
            $validators = [
                'name' => 'required|min:2',
                'email' => 'required|email|unique:users',
            ];
        }

        return array_merge($validators, [
            'message' => 'required',
            'confirmation' => 'required',
        ]);
    }

    public function messages()
    {
        return [
            'name.required' => 'Обязательно укажите свое имя.',
            'name.min' => 'Минимальная длинна имени :min буквы.',
            'email.required' => 'Обязательно укажите свой e-mail.',
            'email.unique' => 'Такой e-mail уже есть у нас в системе. Авторизируйтесь, чтобы оставлять комментарии.',
            'message.required' => 'Обязательно напишите отзыв.',
            'confirmation.required' => 'Вы обязательно должны согласится с модерацией Вашего сообщения.',
        ];
    }
}
