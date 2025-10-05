<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'condition' => 'required|in:Brand new,Like new,Lightly used,Well used,Heavily used',
            'price' => 'required|numeric|min:0|max:99999999',
            'description' => 'nullable|string|max:2000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'images.required' => 'Please upload at least one image.',
            'images.min' => 'Please upload at least one image.',
            'images.max' => 'You can upload a maximum of 5 images.',
            'images.*.image' => 'All uploaded files must be images.',
            'images.*.mimes' => 'Images must be in JPEG, PNG, JPG, GIF, or WebP format.',
            'images.*.max' => 'Each image must not exceed 5MB.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category is invalid.',
            'name.required' => 'The item name is required.',
            'name.max' => 'The item name must not exceed 255 characters.',
            'condition.required' => 'Please select the item condition.',
            'condition.in' => 'The selected condition is invalid.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a number.',
            'price.min' => 'The price must be at least 0.',
            'price.max' => 'The price must not exceed 99,999,999.',
            'description.max' => 'The description must not exceed 2000 characters.',
        ];
    }
}
