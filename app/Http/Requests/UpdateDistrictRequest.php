<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDistrictRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('districts', 'name')
                    ->where(function ($query) {
                        return $query->where('province_id', $this->province_id)
                            ->where('id', '<>', $this->district->id);
                    }),
            ],
            'province_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The Name field is required.',
            'name.unique' => 'This Name is already exists.',
            'province_id.required' => 'The Province field is required.',
        ];
    }
}
