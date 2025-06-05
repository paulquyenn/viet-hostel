<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'desired_move_date' => 'required|date|after:today',
            'duration' => 'required|integer|min:1|max:36',
            'note' => 'nullable|string|max:500',
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
            'desired_move_date.required' => 'Ngày dự kiến chuyển vào là bắt buộc.',
            'desired_move_date.date' => 'Ngày dự kiến chuyển vào phải là định dạng ngày hợp lệ.',
            'desired_move_date.after' => 'Ngày dự kiến chuyển vào phải sau ngày hôm nay.',
            'duration.required' => 'Thời gian thuê là bắt buộc.',
            'duration.integer' => 'Thời gian thuê phải là số nguyên.',
            'duration.min' => 'Thời gian thuê tối thiểu là 1 tháng.',
            'duration.max' => 'Thời gian thuê tối đa là 36 tháng.',
            'note.string' => 'Ghi chú phải là chuỗi ký tự.',
            'note.max' => 'Ghi chú không được vượt quá 500 ký tự.',
        ];
    }
}
