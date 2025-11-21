<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockMovementRequest extends FormRequest
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
            'item_id' => 'required|exists:items,id',
            'quantity_change' => 'required|integer|min:1',
            'type' => 'required|in:in,out',
            'notes' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'item_id.required' => 'Please select an item.',
            'item_id.exists' => 'The selected item does not exist.',
            'quantity_change.required' => 'Quantity is required.',
            'quantity_change.integer' => 'Quantity must be a number.',
            'quantity_change.min' => 'Quantity must be at least 1.',
            'type.required' => 'Please select stock movement type.',
            'type.in' => 'Invalid stock movement type.',
            'notes.max' => 'Notes cannot exceed 500 characters.',
        ];
    }
}
