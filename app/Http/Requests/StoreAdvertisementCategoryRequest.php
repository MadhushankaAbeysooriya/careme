<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdvertisementCategoryRequest extends FormRequest
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
            'name' => 'required|unique:advertisement_categories',
            'amount' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The Name field is required.',
            'name.unique' => 'This Name is already exists',
            'amount.required' => 'The Name field is required.',
        ];
    }
}
