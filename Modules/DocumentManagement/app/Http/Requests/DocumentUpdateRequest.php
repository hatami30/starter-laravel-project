<?php

namespace Modules\DocumentManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'category' => 'required|in:pedoman_manual,kebijakan_program,regulasi,jadwal_on_call_dan_internal_extension,struktur_organisasi,master_dokumen',
            'description' => 'nullable|string|max:1000',
            'file_paths' => 'nullable|array',
            'file_paths.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,xlsx,xls,csv|max:10240',
            'user_id' => 'nullable|exists:users,id',
            'division_id' => 'nullable|exists:divisions,id',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute tidak boleh kosong.',
            'in' => ':attribute harus salah satu dari pilihan yang tersedia.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'numeric' => ':attribute harus berupa angka.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'mimes' => ':attribute harus berupa file dengan format: :values.',
            'nullable' => ':attribute boleh kosong.',
            'exists' => ':attribute tidak ditemukan.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Judul',
            'category' => 'Kategori',
            'description' => 'Deskripsi',
            'file_paths' => 'Dokumen',
            'user_id' => 'ID Pengguna',
            'division_id' => 'ID Divisi',
        ];
    }
}
