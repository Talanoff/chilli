<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserProfileRequest extends FormRequest
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
        return [
            'name' => 'required|min:2',
            'phone' => 'required|min:12'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Обязательно укажите свое имя.',
            'name.min' => 'Минимальная длинна имени :min буквы.',
            'phone.required' => 'Обязательно укажите телефон.',
            'phone.min' => 'Это не похоже на номер телефона.',
        ];
    }
}
