<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchItemsRequest extends FormRequest
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
            'q' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'exists:categories,id'],
            'condition' => ['nullable', 'in:Brand new,Like new,Lightly used,Well used,Heavily used'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
            'sort' => ['nullable', 'in:newest,oldest,price_asc,price_desc'],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $minPrice = $this->input('min_price');
            $maxPrice = $this->input('max_price');

            // Only validate if both are provided
            if ($minPrice !== null && $maxPrice !== null && $maxPrice < $minPrice) {
                $validator->errors()->add('max_price', 'Maximum price must be greater than or equal to minimum price.');
            }
        });
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'category.exists' => 'The selected category does not exist.',
            'condition.in' => 'The selected condition is invalid.',
            'min_price.numeric' => 'Minimum price must be a number.',
            'max_price.numeric' => 'Maximum price must be a number.',
            'max_price.gte' => 'Maximum price must be greater than or equal to minimum price.',
            'sort.in' => 'The selected sort option is invalid.',
        ];
    }
}
