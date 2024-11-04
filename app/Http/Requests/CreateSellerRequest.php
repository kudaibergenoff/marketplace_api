<?php

namespace App\Http\Requests;

class CreateSellerRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|regex:/^7\d{10}$/|unique:users',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя обязательно для заполнения.',
            'name.string' => 'Имя должно быть строкой.',
            'name.max' => 'Имя не должно превышать 255 символов.',
            'email.required' => 'Email обязателен для заполнения.',
            'email.email' => 'Введите действительный адрес электронной почты.',
            'email.max' => 'Email не должен превышать 255 символов.',
            'email.unique' => 'Этот адрес электронной почты уже зарегистрирован.',
            'password.required' => 'Пароль обязателен для заполнения.',
            'password.string' => 'Пароль должен быть строкой.',
            'password.min' => 'Пароль должен содержать не менее 8 символов.',
            'password.confirmed' => 'Пароли не совпадают.',
            'phone.required' => 'Телефон обязателен для заполнения.',
            'phone.string' => 'Телефон должен быть строкой.',
            'phone.regex' => 'Телефон должен быть в формате 77001234567.',
            'phone.unique' => 'Этот номер телефона уже зарегистрирован.',
        ];
    }
}
