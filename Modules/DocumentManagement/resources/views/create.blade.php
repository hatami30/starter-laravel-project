@extends('admin.layouts.app')

@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Tambah Dokumen Baru</h3>
                        <p class="text-subtitle text-muted">Tambahkan dokumen baru ke dalam sistem Anda.</p>
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
                                <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Division Select -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="division_id">Divisi</label>
                                        <select class="form-select @error('division_id') is-invalid @enderror"
                                            id="division_id" name="division_id" required>
                                            <option value="">Pilih divisi</option>
                                            @foreach ($divisions as $division)
                                                <option value="{{ $division->id }}"
                                                    {{ old('division_id') == $division->id ? 'selected' : '' }}>
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
                                            id="title" name="title" value="{{ old('title') }}"
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
                                                {{ old('category') == 'pedoman_manual' ? 'selected' : '' }}>Pedoman Manual
                                            </option>
                                            <option value="kebijakan_program"
                                                {{ old('category') == 'kebijakan_program' ? 'selected' : '' }}>Kebijakan
                                                Program</option>
                                            <option value="regulasi" {{ old('category') == 'regulasi' ? 'selected' : '' }}>
                                                Regulasi</option>
                                            <option value="jadwal_on_call_dan_internal_extension"
                                                {{ old('category') == 'jadwal_on_call_dan_internal_extension' ? 'selected' : '' }}>
                                                Jadwal On Call dan Internal Extension</option>
                                            <option value="struktur_organisasi"
                                                {{ old('category') == 'struktur_organisasi' ? 'selected' : '' }}>Struktur
                                                Organisasi</option>
                                            <option value="master_dokumen"
                                                {{ old('category') == 'master_dokumen' ? 'selected' : '' }}>Master Dokumen
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
                                            placeholder="Masukkan deskripsi dokumen" required>{{ old('description') }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="file_paths">File Dokumen</label>
                                        <div class="custom-file">
                                            <input type="file"
                                                class="form-control @error('file_paths') is-invalid @enderror @error('file_paths.*') is-invalid @enderror"
                                                id="file_paths" name="file_paths[]" multiple onchange="showFileInfo(this)"
                                                required>

                                            <div class="mt-2" id="fileInfo">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Belum ada dokumen. Upload file JPG, PNG, XLSX, CSV, PDF, DOC, atau XLS
                                                (maks. 10MB)
                                            </div>

                                            <div id="filePreviewContainer" class="mt-2"></div>

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
                                            value="1" {{ old('is_public') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_public">Ya</label>
                                        @error('is_public')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Kirim</button>
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

@push('scripts')
    <script>
        // Handle file input changes
        function showFileInfo(input) {
            const fileInfo = document.getElementById('fileInfo');
            const previewContainer = document.getElementById('filePreviewContainer');
            previewContainer.innerHTML = ''; // Clear previous previews

            // Create a DataTransfer object to manipulate the FileList
            const dt = new DataTransfer();

            if (input.files && input.files.length > 0) {
                // Add all files to our DataTransfer object
                Array.from(input.files).forEach(file => {
                    dt.items.add(file);
                });

                // Update info text
                fileInfo.innerHTML = `<i class="bi bi-check-circle-fill text-success me-1"></i>
                                  ${input.files.length} file dipilih`;

                // Create file list preview
                Array.from(input.files).forEach((file, index) => {
                    const fileSize = (file.size / 1024).toFixed(2);
                    const fileSizeText = fileSize < 1024 ?
                        `${fileSize} KB` :
                        `${(fileSize/1024).toFixed(2)} MB`;

                    const fileExt = file.name.split('.').pop().toLowerCase();
                    let iconClass = 'bi-file-earmark';

                    // Set icon based on file type
                    if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExt)) {
                        iconClass = 'bi-file-earmark-image';
                    } else if (['pdf'].includes(fileExt)) {
                        iconClass = 'bi-file-earmark-pdf';
                    } else if (['doc', 'docx'].includes(fileExt)) {
                        iconClass = 'bi-file-earmark-word';
                    } else if (['xls', 'xlsx', 'csv'].includes(fileExt)) {
                        iconClass = 'bi-file-earmark-excel';
                    }

                    // Create preview element
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

                    // Add delete event handler
                    const deleteBtn = filePreview.querySelector('.delete-file');
                    deleteBtn.addEventListener('click', function() {
                        const fileIndex = parseInt(this.getAttribute('data-index'));
                        removeFile(fileIndex, input);
                    });
                });
            } else {
                fileInfo.innerHTML = `
                <i class="bi bi-info-circle me-1"></i>
                Belum ada dokumen. Upload file JPG, PNG, XLSX, CSV, PDF, DOC, atau XLS (maks. 10MB)
            `;
            }
        }

        function removeFile(index, inputElement) {
            const dt = new DataTransfer();
            const files = inputElement.files;

            // Add all files except the one to be removed
            for (let i = 0; i < files.length; i++) {
                if (i !== index) {
                    dt.items.add(files[i]);
                }
            }

            // Update the input's files
            inputElement.files = dt.files;

            // Update the preview
            showFileInfo(inputElement);
        }
    </script>
@endpush
