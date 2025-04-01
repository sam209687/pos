<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'regex:/^[0-9]{4}$/',
                'min:0001',
                'max:9999',
                'unique:products,code' . ($this->product ? ',' . $this->product->id : '')
            ],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'cost_price' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:0'],
            'alert_quantity' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'image' => ['nullable', 'image', 'max:2048'], // Max 2MB
            'status' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.regex' => 'Product code must be exactly 4 digits (0001-9999)',
            'code.min' => 'Product code must be between 0001 and 9999',
            'code.max' => 'Product code must be between 0001 and 9999',
        ];
    }
}
