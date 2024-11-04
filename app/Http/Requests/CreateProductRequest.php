<?php

namespace App\Http\Requests;

class CreateProductRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'exists:categories,id',
            //'seller_id' => 'exists:users,id',
            'status' => 'in:pending,approved,rejected',
            'attributes' => 'required|array',
            'attributes.*.attribute_name' => 'required|string|max:255',
            'attributes.*.attribute_value' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название обязательно для заполнения.',
            'description.required' => 'Описание обязательно для заполнения.',
            'price.required' => 'Цена обязательна для заполнения.',
            'category_id.required' => 'Категория обязательна для заполнения.',
            'status.required' => 'Статус обязательный.',
            'attributes.required' => 'Атрибуты обязательны для заполнения.',
            'attributes.array' => 'Атрибуты должны быть массивом.',
            'attributes.*.attribute_name.required' => 'Название атрибута обязательно для заполнения.',
            'attributes.*.attribute_value.required' => 'Значение атрибута обязательно для заполнения.',
        ];
    }
}
