<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $this->route('product')->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'brand' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date',
            'stock' => 'required|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'string',
            'is_active' => 'boolean',
            'category_id' => 'required|exists:categories,id',
        ];
    }
}