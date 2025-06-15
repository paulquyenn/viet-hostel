<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminContractRequest extends FormRequest
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
            'room_id' => ['required', 'exists:rooms,id'],
            'booking_id' => ['nullable', 'exists:bookings,id'],
            'tenant_id' => ['required', 'exists:users,id'],
            'landlord_id' => ['required', 'exists:users,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'monthly_rent' => ['required', 'numeric', 'min:0'],
            'deposit_amount' => ['required', 'numeric', 'min:0'],
            'terms_and_conditions' => ['required', 'string'],
            'contract_file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
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
            'room_id.required' => 'Phòng là bắt buộc.',
            'room_id.exists' => 'Phòng không tồn tại.',
            'booking_id.exists' => 'Booking không tồn tại.',
            'tenant_id.required' => 'Người thuê là bắt buộc.',
            'tenant_id.exists' => 'Người thuê không tồn tại.',
            'landlord_id.required' => 'Chủ trọ là bắt buộc.',
            'landlord_id.exists' => 'Chủ trọ không tồn tại.',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu phải là định dạng ngày hợp lệ.',
            'end_date.required' => 'Ngày kết thúc là bắt buộc.',
            'end_date.date' => 'Ngày kết thúc phải là định dạng ngày hợp lệ.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
            'monthly_rent.required' => 'Tiền thuê hàng tháng là bắt buộc.',
            'monthly_rent.numeric' => 'Tiền thuê hàng tháng phải là số.',
            'monthly_rent.min' => 'Tiền thuê hàng tháng phải lớn hơn hoặc bằng 0.',
            'deposit_amount.required' => 'Tiền cọc là bắt buộc.',
            'deposit_amount.numeric' => 'Tiền cọc phải là số.',
            'deposit_amount.min' => 'Tiền cọc phải lớn hơn hoặc bằng 0.',
            'terms_and_conditions.required' => 'Điều khoản và điều kiện là bắt buộc.',
            'terms_and_conditions.string' => 'Điều khoản và điều kiện phải là chuỗi ký tự.',
            'contract_file.file' => 'File hợp đồng phải là một file.',
            'contract_file.mimes' => 'File hợp đồng phải có định dạng: pdf, doc, docx.',
            'contract_file.max' => 'File hợp đồng không được vượt quá 10MB.',
        ];
    }
}
