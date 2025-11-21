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
        return auth()->check() && auth()->user()->store_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'code' => [
                'nullable',
                'string',
                'max:255',
                'unique:items,code,NULL,id,store_id,' . auth()->user()->store_id
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:999999999.99',
            ],
            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],
            'category_id' => [
                'nullable',
                'exists:categories,id',
            ],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // If category_id is provided, ensure it belongs to the user's store
            if ($this->category_id) {
                $category = \App\Models\Categories::find($this->category_id);
                if (!$category || $category->store_id !== auth()->user()->store_id) {
                    $validator->errors()->add('category_id', 'The selected category is invalid.');
                }
            }
        });
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Item name is required.',
            'code.unique' => 'This item code already exists in your store.',
            'price.required' => 'Item price is required.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price cannot be negative.',
            'quantity.required' => 'Initial quantity is required.',
            'quantity.integer' => 'Quantity must be a whole number.',
            'quantity.min' => 'Quantity cannot be negative.',
        ];
    }
}