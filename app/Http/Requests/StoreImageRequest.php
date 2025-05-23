<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
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
            'file' => ['required', 'array'],
            'file.*' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:10240', // 10MB max
                'dimensions:min_width=100,min_height=100,max_width=4096,max_height=4096'
            ],
            'isMain' => ['nullable', 'boolean'],
            'room_id' => ['nullable', 'exists:rooms,id']
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
            'file.required' => 'Vui lòng chọn ít nhất một file để tải lên',
            'file.array' => 'Định dạng tải lên không hợp lệ',
            'file.*.required' => 'File không được để trống',
            'file.*.image' => 'File phải là hình ảnh',
            'file.*.mimes' => 'Định dạng hình ảnh không được hỗ trợ (jpg, jpeg, png, gif)',
            'file.*.max' => 'Kích thước file không được vượt quá 10MB',
            'file.*.dimensions' => 'Kích thước hình ảnh không hợp lệ (tối thiểu 100x100px, tối đa 4096x4096px)',
            'room_id.exists' => 'Phòng không tồn tại trong hệ thống'
        ];
    }
}
