<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FastBuyRequest extends FormRequest
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
            'email' => 'required|email',
            'phone' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Обязательно укажите свое имя.',
            'name.min' => 'Минимальная длинна имени :min буквы.',
            'email.required' => 'Обязательно укажите свой e-mail.',
        ];
    }
}
