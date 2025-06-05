<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
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
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
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
            'current_password.required' => 'Mật khẩu hiện tại là bắt buộc.',
            'current_password.current_password' => 'Mật khẩu hiện tại không chính xác.',
            'password.required' => 'Mật khẩu mới là bắt buộc.',
            'password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ];
    }

    /**
     * Get the validation error bag for the defined validation rules.
     *
     * @return string
     */
    protected function errorBag(): string
    {
        return 'updatePassword';
    }
}
