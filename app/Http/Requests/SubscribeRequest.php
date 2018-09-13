<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscribeRequest extends FormRequest
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
            'email' => 'email|unique:subscribes',
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'Это не похоже на e-mail',
            'email.unique' => 'Такой e-mail уже есть у нас в системе',
        ];
    }
}
