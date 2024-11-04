<?php

namespace App\Http\Requests;

class UpdateSellerRequest extends BaseRequest
{
    public function rules(): array
    {
        $userId = $this->route('id');

        return [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|regex:/^7\d{10}$/|unique:users,phone,' . $userId,
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Имя должно быть строкой.',
            'name.max' => 'Имя не должно превышать 255 символов.',
            'email.email' => 'Введите действительный адрес электронной почты.',
            'email.max' => 'Email не должен превышать 255 символов.',
            'email.unique' => 'Этот адрес электронной почты уже зарегистрирован.',
            'password.string' => 'Пароль должен быть строкой.',
            'password.min' => 'Пароль должен содержать не менее 8 символов.',
            'password.confirmed' => 'Пароли не совпадают.',
            'phone.string' => 'Телефон должен быть строкой.',
            'phone.regex' => 'Телефон должен быть в формате 77001234567.',
            'phone.unique' => 'Этот номер телефона уже зарегистрирован.',
        ];
    }
}
