<?php

namespace Modules\Division\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DivisionUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:divisions,name,' . $this->division->id,
            'description' => 'nullable|string|max:500',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama divisi harus diisi.',
            'name.string' => 'Nama divisi harus berupa teks.',
            'name.max' => 'Nama divisi tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Nama divisi yang Anda masukkan sudah ada, harap pilih nama yang berbeda.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi divisi tidak boleh lebih dari 500 karakter.',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'name' => trim($this->name),
        ]);
    }
}
