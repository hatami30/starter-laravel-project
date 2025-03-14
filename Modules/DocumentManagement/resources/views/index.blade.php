@extends('admin.layouts.app')

@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Dokumen</h3>
                        <p class="text-subtitle text-muted">Lihat dan kelola semua dokumen.</p>
                    </div>
                    @if (isset($userDivision))
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <div class="float-end">
                                <span class="badge bg-primary">Divisi: {{ $userDivision }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-header d-flex justify-content-end align-items-center">
                                <div class="d-flex align-items-center">
                                    <!-- Button for Table Settings Modal -->
                                    <button type="button" class="btn border-0 p-0 me-3" data-bs-toggle="modal"
                                        data-bs-target="#tableSettingsModal">
                                        <i class='bx bx-sm bx-cog'></i>
                                    </button>

                                    <!-- Table Settings Modal -->
                                    <div class="modal fade" id="tableSettingsModal" tabindex="-1"
                                        aria-labelledby="tableSettingsModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="tableSettingsModalLabel">Pengaturan Tabel
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST"
                                                        action="{{ route('documents.save.table.settings') }}">
                                                        @csrf
                                                        <h6 class="fw-bold">Visibilitas Kolom</h6>
                                                        <p class="text-muted">Pilih kolom yang ingin Anda tampilkan di
                                                            tabel.</p>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="d-grid"
                                                                    style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                                                                    @foreach ($columns as $column)
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                name="columns[]" value="{{ $column }}"
                                                                                id="column-{{ $column }}"
                                                                                @if (in_array($column, $visibleColumns)) checked @endif>
                                                                            <label class="form-check-label"
                                                                                for="column-{{ $column }}">{{ ucfirst($column) }}</label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <h6 class="fw-bold mt-4">Tampilkan Nomor Baris</h6>
                                                        <p class="text-muted">Aktifkan opsi ini untuk menampilkan nomor
                                                            baris di sampingnya.</p>
                                                        <div class="form-check form-switch mt-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="show_numbering" id="show_numbering"
                                                                @if (old('show_numbering') || ($savedSettings->show_numbering ?? false)) checked @endif>
                                                            <label class="form-check-label" for="show_numbering">Tampilkan
                                                                Nomor
                                                                Baris</label>
                                                        </div>

                                                        <div class="form-group my-4">
                                                            <h6 for="limit" class="fw-bold mt-4">Item per Halaman (Batas)
                                                            </h6>
                                                            <p class="text-muted">Pilih berapa banyak item yang harus
                                                                ditampilkan
                                                                per halaman di tabel.</p>
                                                            <select name="limit" class="form-select">
                                                                @foreach ([5, 10, 20, 50, 100] as $limit)
                                                                    <option value="{{ $limit }}"
                                                                        {{ (old('limit') ?: $savedSettings->limit ?? 10) == $limit ? 'selected' : '' }}>
                                                                        {{ $limit }} item
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary">Simpan
                                                                Pengaturan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @can('create_documents', $documents)
                                        <a href="{{ route('documents.create') }}" type="button" class="btn border-0 p-0 me-3">
                                            <i class='bx bx-sm bx-plus-circle'></i>
                                        </a>
                                    @endcan
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-lg">
                                        <thead>
                                            <tr>
                                                @if ($savedSettings->show_numbering ?? false)
                                                    <th>No.</th>
                                                @endif

                                                @foreach ($visibleColumns as $visibleColumn)
                                                    <!-- Conditionally hide columns for non-"Mutu" divisions -->
                                                    @if (Auth::check() &&
                                                            ((Auth::user()->division && Auth::user()->division->name === 'Mutu') || $visibleColumn !== 'sensitive_column'))
                                                        <th>{{ $columnLabels[$visibleColumn] ?? ucfirst(str_replace('_', ' ', $visibleColumn)) }}
                                                        </th>
                                                    @endif
                                                @endforeach

                                                @if (Auth::check() &&
                                                        (Auth::user()->can('edit_documents') ||
                                                            Auth::user()->can('delete_documents') ||
                                                            Auth::user()->can('view_documents')))
                                                    <th>Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($documents as $document)
                                                <tr>
                                                    @if ($savedSettings->show_numbering ?? false)
                                                        <td class="text-bold-500">{{ $loop->iteration }}</td>
                                                    @endif

                                                    @foreach ($visibleColumns as $column)
                                                        <!-- Conditionally hide data for non-"Mutu" divisions -->
                                                        @if (Auth::check() && (Auth::user()->division->name === 'Mutu' || $column !== 'sensitive_column'))
                                                            <td>
                                                                {{ is_array($document->{$column}) ? implode(', ', $document->{$column}) : $document->{$column} }}
                                                            </td>
                                                        @endif
                                                    @endforeach

                                                    <td>
                                                        <div class="d-flex justify-content-center gap-2">
                                                            @if ($document->file_paths && (is_array($document->file_paths) || count(json_decode($document->file_paths)) > 0))
                                                                <div class="dropdown">
                                                                    <button
                                                                        class="btn btn-sm btn-outline-info d-flex justify-content-center align-items-center p-0"
                                                                        style="width: 36px; height: 36px;" type="button"
                                                                        id="documentsDropdown{{ $document->id }}"
                                                                        data-bs-toggle="dropdown" aria-expanded="false"
                                                                        title="Documents">
                                                                        <i class="bx bx-download"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu"
                                                                        aria-labelledby="documentsDropdown{{ $document->id }}">
                                                                        @foreach (is_array($document->file_paths) ? $document->file_paths : json_decode($document->file_paths) as $index => $file)
                                                                            <li>
                                                                                <a class="dropdown-item d-flex align-items-center"
                                                                                    href="{{ asset('storage/' . $file) }}"
                                                                                    download="Document-{{ $index + 1 }}-{{ $document->id }}">
                                                                                    <i
                                                                                        class='bx bx-file me-2'></i>{{ $index + 1 }}
                                                                                </a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @else
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-secondary d-flex justify-content-center align-items-center p-0"
                                                                    style="width: 36px; height: 36px;" disabled
                                                                    title="No Documents">
                                                                    <i class="bx bx-download"></i>
                                                                </button>
                                                            @endif

                                                            @can('edit_documents', $document)
                                                                <a href="{{ route('documents.edit', $document->id) }}"
                                                                    class="btn btn-sm btn-outline-warning d-flex justify-content-center align-items-center p-0"
                                                                    style="width: 36px; height: 36px;" title="Edit">
                                                                    <i class="bx bx-edit"></i>
                                                                </a>
                                                            @endcan

                                                            @can('delete_documents', $document)
                                                                <form method="POST"
                                                                    action="{{ route('documents.destroy', $document->id) }}"
                                                                    style="margin: 0;" class="delete-form">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-outline-danger d-flex justify-content-center align-items-center p-0 delete-btn"
                                                                        style="width: 36px; height: 36px;" title="Delete">
                                                                        <i class="bx bx-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endcan
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-center"
                                                        colspan="{{ count($visibleColumns) + ($savedSettings->show_numbering ?? false ? 2 : 1) }}">
                                                        Tidak Ada Data
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        {{ $documents->withQueryString()->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Confirmation before deletion
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');

                // Confirmation using SweetAlert2
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan bisa mengembalikannya!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'btn btn-primary mx-1',
                        cancelButton: 'btn btn-danger mx-1'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit the form if confirmed
                    }
                });
            });
        });

        // Display notification if operation was successful
        @if (session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        // Display notification if operation failed
        @if (session('error'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    </script>
@endpush
