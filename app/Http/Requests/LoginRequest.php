<?php

namespace App\Http\Requests;

class LoginRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email обязателен для заполнения.',
            'email.email' => 'Введите действительный адрес электронной почты.',
            'email.max' => 'Email не должен превышать 255 символов.',
            'password.required' => 'Пароль обязателен для заполнения.',
            'password.string' => 'Пароль должен быть строкой.',
            'password.min' => 'Пароль должен содержать не менее 8 символов.'
        ];
    }
}
