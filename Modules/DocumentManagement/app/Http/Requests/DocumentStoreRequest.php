<?php

namespace Modules\DocumentManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'division_id' => 'required|exists:divisions,id',
            'title' => 'required|string|max:255',
            'category' => 'required|in:pedoman_manual,kebijakan_program,regulasi,jadwal_on_call_dan_internal_extension,struktur_organisasi,master_dokumen',
            'description' => 'nullable|string|max:1000',
            'file_paths' => 'required|array',
            'file_paths.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,xlsx,xls,csv|max:10240',
            'user_id' => 'nullable|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute tidak boleh kosong.',
            'in' => ':attribute harus salah satu dari pilihan yang tersedia.',
            'numeric' => ':attribute harus berupa angka.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'mimes' => ':attribute harus berupa file dengan format: :values.',
            'nullable' => ':attribute boleh kosong.',
            'exists' => ':attribute tidak ditemukan.',
            'file_paths.*.file' => 'Setiap file di :attribute harus berupa file yang valid.',
            'file_paths.*.max' => 'Setiap file di :attribute tidak boleh lebih dari 10MB.',
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