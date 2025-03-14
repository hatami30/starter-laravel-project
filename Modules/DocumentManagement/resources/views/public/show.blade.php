@extends('documentmanagement::layouts.public-layout')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg mx-auto max-w-4xl">
        <!-- DIVISI Section -->
        <div class="text-center mb-6">
            <h2 class="text-3xl font-semibold text-green-600">{{ $document->division->name }}</h2>
        </div>

        <!-- Kategori Section -->
        <div class="mb-4">
            <h3 class="text-lg font-medium text-gray-700">Kategori: <span
                    class="font-semibold">{{ ucfirst(str_replace('_', ' ', $document->category)) }}</span></h3>
        </div>

        <!-- Title Section -->
        <div class="mb-4">
            <h4 class="text-2xl font-semibold text-gray-800">{{ $document->title }}</h4>
        </div>

        <!-- Deskripsi Section -->
        <div class="mb-6">
            <p class="text-gray-600">{{ $document->description }}</p>
        </div>

        <!-- Linked Division (Optional) -->
        @if ($document->linked_division_id)
            <div class="mb-4">
                <h5 class="font-semibold">Divisi Terkait: {{ $document->linkedDivision->name }}</h5>
            </div>
        @endif

        <!-- Files Section -->
        <div class="mb-6">
            <h5 class="text-lg font-medium text-gray-700 mb-2">Files:</h5>
            <ul class="space-y-2">
                @foreach (json_decode($document->file_paths, true) as $filePath)
                    <li>
                        <a href="{{ Storage::url($filePath) }}" target="_blank" class="text-blue-600 hover:underline"
                            download>Lihat / Download</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
