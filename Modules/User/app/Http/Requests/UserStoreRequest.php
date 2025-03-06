<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|max:15|unique:users,phone|regex:/^\+?[0-9]{10,15}$/',
            'division_id' => 'required|exists:divisions,id',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|string|min:8',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'role_id.required' => 'Role harus dipilih.',
            'role_id.exists' => 'Role yang dipilih tidak valid.',
            'name.required' => 'Nama harus diisi.',
            'name.string' => 'Nama harus berupa string.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'username.required' => 'Username harus diisi.',
            'username.string' => 'Username harus berupa string.',
            'username.max' => 'Username tidak boleh lebih dari 255 karakter.',
            'username.unique' => 'Username sudah ada.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Email sudah ada.',
            'phone.required' => 'Nomor telepon harus diisi.',
            'phone.max' => 'Nomor telepon tidak boleh lebih dari 15 karakter.',
            'phone.unique' => 'Nomor telepon sudah ada.',
            'phone.regex' => 'Nomor telepon tidak valid. Pastikan format yang benar (misalnya: +628123456789).',
            'division_id.required' => 'Divisi harus dipilih.',
            'division_id.exists' => 'Divisi yang dipilih tidak valid.',
            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status tidak valid.',
            'password.required' => 'Password harus diisi.',
            'password.string' => 'Password harus berupa string.',
            'password.min' => 'Password harus memiliki minimal 8 karakter.',
            // 'password.regex' => 'Password harus mengandung minimal satu huruf besar, satu huruf kecil, satu angka, dan satu karakter khusus.',
        ];
    }
}
