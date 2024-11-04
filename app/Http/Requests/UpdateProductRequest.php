<?php

namespace App\Http\Requests;

class UpdateProductRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'category_id' => 'sometimes|required|exists:categories,id',
            'status' => 'sometimes|required|in:pending,approved,rejected',
            'attributes' => 'sometimes|required|array',
            'attributes.*.attribute_name' => 'sometimes|required|string|max:255',
            'attributes.*.attribute_value' => 'sometimes|required|string|max:255',
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
