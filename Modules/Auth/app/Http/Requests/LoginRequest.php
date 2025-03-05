<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'identity' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return [
            'identity' => 'Username or Email',
            'password' => 'Password',
        ];
    }
}
