<?php

namespace Modules\Division\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DivisionStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:divisions,name',
            'description' => 'nullable|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama divisi wajib diisi.',
            'name.string' => 'Nama divisi harus berupa teks.',
            'name.max' => 'Nama divisi tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Nama divisi yang Anda masukkan sudah ada, harap pilih nama yang berbeda.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi divisi tidak boleh lebih dari 500 karakter.',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim($this->name),
        ]);
    }
}
