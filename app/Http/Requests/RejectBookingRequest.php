<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RejectBookingRequest extends FormRequest
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
            'reject_reason' => 'required|string|max:500',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'reject_reason.required' => 'Lý do từ chối là bắt buộc.',
            'reject_reason.string' => 'Lý do từ chối phải là chuỗi ký tự.',
            'reject_reason.max' => 'Lý do từ chối không được vượt quá 500 ký tự.',
        ];
    }
}
