<?php

namespace App\Http\Requests;

class CreateCategoryRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => 'nullable|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'parent_id.integer' => 'ID родительской категории должен быть целым числом.',
            'parent_id.exists' => 'Выбранная родительская категория не существует.',
            'name.required' => 'Имя обязательно для заполнения.',
            'name.string' => 'Имя должно быть строкой.',
            'name.max' => 'Имя не должно превышать 255 символов.',
            'slug.required' => 'Слаг обязателен для заполнения.',
            'slug.string' => 'Слаг должен быть строкой.',
            'slug.max' => 'Слаг не должен превышать 255 символов.',
            'slug.unique' => 'Этот слаг уже зарегистрирован.',
            'description.string' => 'Описание должно быть строкой.',
            'status.required' => 'Статус обязательно для заполнения.',
            'status.boolean' => 'Статус должен быть true или false.',
        ];
    }
}
