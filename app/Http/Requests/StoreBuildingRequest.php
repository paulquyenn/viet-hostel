<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBuildingRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'ward_id' => ['required', 'numeric', 'exists:wards,id'],
            'district_id' => ['required', 'numeric', 'exists:districts,id'],
            'province_id' => ['required', 'numeric', 'exists:provinces,id'],
            'user_id' => ['nullable', 'numeric', 'exists:users,id'],
        ];
    }
}
