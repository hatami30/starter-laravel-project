@extends('documentmanagement::layouts.public-layout')

@section('content')
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-green-700">Dokumen di Divisi: {{ $division->name }} - Kategori:
            {{ ucfirst(str_replace('_', ' ', $categoryName)) }}</h1>
        <p class="text-lg text-gray-600 mt-2">Berikut adalah daftar dokumen yang tersedia di divisi ini dan kategori yang
            dipilih.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($documents as $document)
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow">
                <h2 class="text-2xl font-semibold text-green-600 mb-2">{{ $document->title }}</h2>
                <p class="text-gray-700 mb-4">{{ Str::limit($document->description, 150) }}</p>
                <a href="{{ route('documents.public.show', $document->id) }}"
                    class="inline-block bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">Lihat
                    Detail</a>
            </div>
        @endforeach
    </div>

    <div class="mt-10 text-center">
        <a href="{{ route('documents.public.index') }}" class="text-blue-600 hover:underline">Kembali ke Daftar Divisi</a>
    </div>
@endsection
