<?php

namespace App\Http\Requests\Api;

class CaptchaRequest extends FormRequest
{
    public function rules()
    {
        return [
            'phone' => [
                'required',
                'regex:/^1\d{10}$/',
                'unique:users'
            ]
        ];
    }
}
