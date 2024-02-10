<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdvertisementRequest extends FormRequest
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
            'name' => 'required|unique:advertisements',
            'filepath' => 'required',
            'advertisement_category_id' => 'required',
            // 'amount' => 'required',
            // 'total' => 'required',
            'url' => 'required',
            'from' => 'required|date',
            'to' => 'required|date|after:from',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The Name field is required.',
            'name.unique' => 'This Name is already exists',
            'filepath.required' => 'The File selection is required.',
            'advertisement_category_id.required' => 'The Category field is required.',
            // 'amount.required' => 'The Amount field is required.',
            // 'total.required' => 'The Name field is required.',
            'url.required' => 'The URL field is required.',
            'from.required' => 'The from field is required.',
            'from.date' => 'The from field is must be a date.',
            'to.required' => 'The to field is required.',
            'to.date' => 'The to field is must be a date.',
            'to.after' => 'The to field is must be after from date.',
        ];
    }
}
