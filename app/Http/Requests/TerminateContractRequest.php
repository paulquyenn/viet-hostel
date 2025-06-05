<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TerminateContractRequest extends FormRequest
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
            'termination_reason' => 'required|string|max:500',
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
            'termination_reason.required' => 'Lý do chấm dứt hợp đồng là bắt buộc.',
            'termination_reason.string' => 'Lý do chấm dứt phải là chuỗi ký tự.',
            'termination_reason.max' => 'Lý do chấm dứt không được vượt quá 500 ký tự.',
        ];
    }
}
