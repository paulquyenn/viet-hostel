<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContractRequest extends FormRequest
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
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'monthly_rent' => 'required|numeric|min:0',
            'deposit_amount' => 'required|numeric|min:0',
            'terms_and_conditions' => 'required|string',
            'contract_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
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
            'start_date.required' => 'Ngày bắt đầu hợp đồng là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu phải là định dạng ngày hợp lệ.',
            'end_date.required' => 'Ngày kết thúc hợp đồng là bắt buộc.',
            'end_date.date' => 'Ngày kết thúc phải là định dạng ngày hợp lệ.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
            'monthly_rent.required' => 'Tiền thuê hàng tháng là bắt buộc.',
            'monthly_rent.numeric' => 'Tiền thuê phải là số.',
            'monthly_rent.min' => 'Tiền thuê không được âm.',
            'deposit_amount.required' => 'Tiền đặt cọc là bắt buộc.',
            'deposit_amount.numeric' => 'Tiền đặt cọc phải là số.',
            'deposit_amount.min' => 'Tiền đặt cọc không được âm.',
            'terms_and_conditions.required' => 'Điều khoản hợp đồng là bắt buộc.',
            'terms_and_conditions.string' => 'Điều khoản phải là chuỗi ký tự.',
            'contract_file.file' => 'File hợp đồng phải là file hợp lệ.',
            'contract_file.mimes' => 'File hợp đồng phải có định dạng: pdf, doc, docx.',
            'contract_file.max' => 'File hợp đồng không được vượt quá 10MB.',
        ];
    }
}
