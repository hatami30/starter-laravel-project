@extends('admin.layouts.app')

@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Edit Dokumen</h3>
                        <p class="text-subtitle text-muted">Perbarui informasi dokumen di sistem Anda.</p>
                    </div>
                </div>
            </div>
        </div>

        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form method="POST" action="{{ route('documents.update', $document->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <!-- Division Select -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="division_id">Divisi</label>
                                        <select class="form-select @error('division_id') is-invalid @enderror"
                                            id="division_id" name="division_id" required>
                                            <option value="">Pilih divisi</option>
                                            @foreach ($divisions as $division)
                                                <option value="{{ $division->id }}"
                                                    {{ old('division_id', $document->division_id) == $division->id ? 'selected' : '' }}>
                                                    {{ $division->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('division_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="title">Judul Dokumen</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ old('title', $document->title) }}"
                                            placeholder="Masukkan judul dokumen" required>
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="category">Kategori Dokumen</label>
                                        <select class="form-select @error('category') is-invalid @enderror" id="category"
                                            name="category" required>
                                            <option value="">Pilih kategori</option>
                                            <option value="pedoman_manual"
                                                {{ old('category', $document->category) == 'pedoman_manual' ? 'selected' : '' }}>
                                                Pedoman Manual
                                            </option>
                                            <option value="kebijakan_program"
                                                {{ old('category', $document->category) == 'kebijakan_program' ? 'selected' : '' }}>
                                                Kebijakan Program
                                            </option>
                                            <option value="regulasi"
                                                {{ old('category', $document->category) == 'regulasi' ? 'selected' : '' }}>
                                                Regulasi
                                            </option>
                                            <option value="jadwal_on_call_dan_internal_extension"
                                                {{ old('category', $document->category) == 'jadwal_on_call_dan_internal_extension' ? 'selected' : '' }}>
                                                Jadwal On Call dan Internal Extension
                                            </option>
                                            <option value="struktur_organisasi"
                                                {{ old('category', $document->category) == 'struktur_organisasi' ? 'selected' : '' }}>
                                                Struktur Organisasi
                                            </option>
                                            <option value="master_dokumen"
                                                {{ old('category', $document->category) == 'master_dokumen' ? 'selected' : '' }}>
                                                Master Dokumen
                                            </option>
                                        </select>
                                        @error('category')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="description">Deskripsi</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            placeholder="Masukkan deskripsi dokumen" required>{{ old('description', $document->description) }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label" for="file_paths">File Dokumen</label>
                                        <div class="custom-file">
                                            <input type="file"
                                                class="form-control @error('file_paths') is-invalid @enderror @error('file_paths.*') is-invalid @enderror"
                                                id="file_paths" name="file_paths[]" multiple onchange="showFileInfo(this)">

                                            <div class="mt-2" id="fileInfo">
                                                @if ($document->file_paths && count($document->file_paths) > 0)
                                                    <i class="bi bi-check-circle-fill text-success me-1"></i>
                                                    {{ count($document->file_paths) }} file tersedia
                                                @else
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    Belum ada dokumen. Upload file JPG, PNG, XLSX, CSV, PDF, DOC, atau XLS
                                                    (maks. 10MB)
                                                @endif
                                            </div>

                                            <div class="mt-3">
                                                <label class="form-label">File Dokumen Saat Ini:</label>
                                                <div id="existingFilesContainer">
                                                    @if ($document->file_paths && count($document->file_paths) > 0)
                                                        @foreach ($document->file_paths as $index => $file)
                                                            <div
                                                                class="border rounded p-2 mb-2 d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center">
                                                                    <i
                                                                        class="bi bi-file-earmark-{{ getFileIcon($file) }} me-2 fs-4"></i>
                                                                    <div>
                                                                        <div class="fw-bold">{{ basename($file) }}</div>
                                                                        <div class="small text-muted">
                                                                            {{ formatFileSize($file) }}</div>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <a href="{{ asset($file) }}"
                                                                        class="btn btn-sm btn-info me-1" target="_blank">
                                                                        <i class="bi bi-eye"></i>
                                                                    </a>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-danger delete-existing-file"
                                                                        data-file-index="{{ $index }}">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                    <input type="hidden" name="existing_files[]"
                                                                        value="{{ $file }}">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="text-muted">Tidak ada file terlampir</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="mt-3">
                                                <label class="form-label">File Baru yang akan Ditambahkan:</label>
                                                <div id="filePreviewContainer" class="mt-2"></div>
                                            </div>

                                            @error('file_paths')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            @error('file_paths.*')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label" for="is_public">Apakah Dokumen Publik?</label>
                                        <input type="checkbox" class="form-check-input" id="is_public" name="is_public"
                                            value="1" {{ old('is_public', $document->is_public) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_public">Ya</label>
                                        @error('is_public')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="reset"
                                                class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Simpan
                                                Perubahan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@php
    function getFileIcon($file)
    {
        $extension = pathinfo($file, PATHINFO_EXTENSION);

        switch (strtolower($extension)) {
            case 'pdf':
                return 'pdf';
            case 'doc':
            case 'docx':
                return 'word';
            case 'xls':
            case 'xlsx':
            case 'csv':
                return 'excel';
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                return 'image';
            default:
                return '';
        }
    }

    function formatFileSize($file)
    {
        $size = @filesize(public_path($file));
        if ($size === false) {
            return 'Unknown size';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($size >= 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }

        return round($size, 2) . ' ' . $units[$i];
    }
@endphp

@push('scripts')
    <script>
        // Handle file input changes
        function showFileInfo(input) {
            const fileInfo = document.getElementById('fileInfo');
            const previewContainer = document.getElementById('filePreviewContainer');
            previewContainer.innerHTML = ''; // Clear previous previews

            const dt = new DataTransfer();

            if (input.files && input.files.length > 0) {
                Array.from(input.files).forEach(file => {
                    dt.items.add(file);
                });

                // Update info text for new files
                const existingFilesCount = document.querySelectorAll('#existingFilesContainer .border').length;
                const newFilesCount = input.files.length;
                const totalFiles = existingFilesCount + newFilesCount;
                fileInfo.innerHTML = `<i class="bi bi-check-circle-fill text-success me-1"></i>
                  ${totalFiles} file akan tersedia setelah menyimpan`;

                // Create preview for new files
                Array.from(input.files).forEach((file, index) => {
                    const fileSize = (file.size / 1024).toFixed(2);
                    const fileSizeText = fileSize < 1024 ?
                        `${fileSize} KB` :
                        `${(fileSize/1024).toFixed(2)} MB`;

                    const fileExt = file.name.split('.').pop().toLowerCase();
                    let iconClass = 'bi-file-earmark';

                    if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExt)) {
                        iconClass = 'bi-file-earmark-image';
                    } else if (['pdf'].includes(fileExt)) {
                        iconClass = 'bi-file-earmark-pdf';
                    } else if (['doc', 'docx'].includes(fileExt)) {
                        iconClass = 'bi-file-earmark-word';
                    } else if (['xls', 'xlsx', 'csv'].includes(fileExt)) {
                        iconClass = 'bi-file-earmark-excel';
                    }

                    const filePreview = document.createElement('div');
                    filePreview.className =
                        'border rounded p-2 mb-2 d-flex align-items-center justify-content-between';
                    filePreview.innerHTML = `
          <div class="d-flex align-items-center">
            <i class="bi ${iconClass} me-2 fs-4"></i>
            <div>
              <div class="fw-bold">${file.name}</div>
              <div class="small text-muted">${fileSizeText}</div>
            </div>
          </div>
          <button type="button" class="btn btn-sm btn-danger delete-file" data-index="${index}">
            <i class="bi bi-x"></i>
          </button>
        `;

                    previewContainer.appendChild(filePreview);

                    const deleteBtn = filePreview.querySelector('.delete-file');
                    deleteBtn.addEventListener('click', function() {
                        const fileIndex = parseInt(this.getAttribute('data-index'));
                        removeFile(fileIndex, input);
                    });
                });
            } else if (previewContainer.children.length === 0) {
                const existingFilesCount = document.querySelectorAll('#existingFilesContainer .border').length;
                if (existingFilesCount > 0) {
                    fileInfo.innerHTML = `<i class="bi bi-check-circle-fill text-success me-1"></i>
                    ${existingFilesCount} file tersedia`;
                } else {
                    fileInfo.innerHTML = `
          <i class="bi bi-info-circle me-1"></i>
          Belum ada dokumen. Upload file JPG, PNG, XLSX, CSV, PDF, DOC, atau XLS (maks. 10MB)
        `;
                }
            }
        }

        function removeFile(index, inputElement) {
            const dt = new DataTransfer();
            const files = inputElement.files;

            for (let i = 0; i < files.length; i++) {
                if (i !== index) {
                    dt.items.add(files[i]);
                }
            }

            inputElement.files = dt.files;
            showFileInfo(inputElement);
        }

        // Handle existing file deletion
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-existing-file');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const fileContainer = this.closest('.border');
                    const hiddenInput = fileContainer.querySelector(
                        'input[name="existing_files[]"]');

                    // Create a hidden input to track deleted files
                    const deletedInput = document.createElement('input');
                    deletedInput.type = 'hidden';
                    deletedInput.name = 'deleted_files[]';
                    deletedInput.value = hiddenInput.value;
                    document.querySelector('form').appendChild(deletedInput);

                    // Remove the file container
                    fileContainer.remove();

                    // Update file info
                    const existingFilesCount = document.querySelectorAll(
                        '#existingFilesContainer .border').length;
                    const newFilesCount = document.getElementById('file_paths').files.length;
                    const totalFiles = existingFilesCount + newFilesCount;

                    const fileInfo = document.getElementById('fileInfo');
                    if (totalFiles > 0) {
                        fileInfo.innerHTML = `<i class="bi bi-check-circle-fill text-success me-1"></i>
                      ${totalFiles} file akan tersedia setelah menyimpan`;
                    } else {
                        fileInfo.innerHTML = `
            <i class="bi bi-info-circle me-1"></i>
            Belum ada dokumen. Upload file JPG, PNG, XLSX, CSV, PDF, DOC, atau XLS (maks. 10MB)
          `;
                    }
                });
            });
        });
    </script>
@endpush
