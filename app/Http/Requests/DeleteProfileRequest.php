<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteProfileRequest extends FormRequest
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
            'password' => ['required', 'current_password'],
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
            'password.required' => 'Mật khẩu là bắt buộc để xác nhận xóa tài khoản.',
            'password.current_password' => 'Mật khẩu không chính xác.',
        ];
    }

    /**
     * Get the validation error bag for the defined validation rules.
     *
     * @return string
     */
    protected function errorBag(): string
    {
        return 'userDeletion';
    }
}
