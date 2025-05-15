<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInventoryItemRequest extends FormRequest
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
            'name' => ['required'],
            'description' => ['nullable'],
            'quantity' => ['required', 'integer'],
            'sku' => ['nullable', 'unique:inventory_items,sku,' . $this->route('inventory_item')],
            'status' => ['required'],
        ];
    }
}
