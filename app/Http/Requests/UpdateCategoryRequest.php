<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && 
               auth()->user()->store_id && 
               $this->route('category')->store_id === auth()->user()->store_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $categoryId = $this->route('category')->id;
        
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name,' . $categoryId . ',id,store_id,' . auth()->user()->store_id
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required.',
            'name.unique' => 'This category name already exists in your store.',
            'name.max' => 'Category name cannot exceed 255 characters.',
        ];
    }
}