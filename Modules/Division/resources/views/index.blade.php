@extends('admin.layouts.app')

@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Divisi</h3>
                        <p class="text-subtitle text-muted">Lihat dan kelola semua divisi.</p>
                    </div>
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
                                    <button type="button" class="btn border-0 p-0 me-3" data-bs-toggle="modal"
                                        data-bs-target="#tableSettingsModal">
                                        <i class="bx bx-sm bx-cog"></i>
                                    </button>

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
                                                        action="{{ route('divisions.save.table.settings') }}">
                                                        @csrf
                                                        <h6 class="fw-bold">Visibilitas Kolom</h6>
                                                        <p class="text-muted">Pilih kolom yang ingin Anda tampilkan dalam
                                                            tabel.</p>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="d-grid"
                                                                    style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                                                                    @foreach ($allColumns as $column)
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
                                                        <p class="text-muted">Aktifkan opsi ini untuk menampilkan nomor pada
                                                            setiap baris.</p>
                                                        <div class="form-check form-switch mt-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="show_numbering" id="show_numbering"
                                                                @if (old('show_numbering') || ($savedSettings->show_numbering ?? false)) checked @endif>
                                                            <label class="form-check-label" for="show_numbering">Tampilkan
                                                                Nomor
                                                                Baris</label>
                                                        </div>

                                                        <div class="form-group my-4">
                                                            <h6 class="fw-bold mt-4">Item Per Halaman (Batas)</h6>
                                                            <p class="text-muted">Pilih jumlah item yang akan ditampilkan di
                                                                tabel.</p>
                                                            <select name="limit" class="form-select">
                                                                @foreach ($limits as $limitOption)
                                                                    <option value="{{ $limitOption }}"
                                                                        {{ (old('limit') ?: $limit) == $limitOption ? 'selected' : '' }}>
                                                                        {{ $limitOption }} item
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

                                    <button type="button" class="btn border-0 p-0 me-3" data-bs-toggle="modal"
                                        data-bs-target="#tableFiltersModal">
                                        <i class='bx bx-sm bx-filter-alt'></i>
                                    </button>

                                    <div class="modal fade" id="tableFiltersModal" tabindex="-1"
                                        aria-labelledby="tableFiltersModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="tableFiltersModalLabel">Filter Tabel</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="GET" action="{{ route('divisions.index') }}">
                                                        <div class="mb-3">
                                                            <label for="name" class="fw-bold">Cari:</label>
                                                            <input type="text" name="q" class="form-control"
                                                                placeholder="Cari" value="{{ request('q') }}" />
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="limit" class="fw-bold">Batas:</label>
                                                            <select name="limit" class="form-select">
                                                                @foreach ($limits as $limitOption)
                                                                    <option value="{{ $limitOption }}"
                                                                        {{ (request('limit') ?: $savedSettings->limit ?? 10) == $limitOption ? 'selected' : '' }}>
                                                                        {{ $limitOption }} item
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="sort_by" class="fw-bold">Urutkan
                                                                Berdasarkan:</label>
                                                            <select name="sort_by" class="form-select">
                                                                @foreach ($visibleColumns as $column)
                                                                    @if (!in_array($column, $excludedSortColumns))
                                                                        <option value="{{ $column }}"
                                                                            {{ request('sort_by') == $column ? 'selected' : '' }}>
                                                                            {{ ucfirst(str_replace('_', ' ', $column)) }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="sort_order" class="fw-bold">Urutan:</label>
                                                            <select name="sort_order" class="form-select">
                                                                <option value="ASC"
                                                                    {{ request('sort_order') == 'ASC' ? 'selected' : '' }}>
                                                                    Ascending</option>
                                                                <option value="DESC"
                                                                    {{ request('sort_order') == 'DESC' ? 'selected' : '' }}>
                                                                    Descending</option>
                                                            </select>
                                                        </div>

                                                        <div class="d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary">Terapkan
                                                                Filter</button>
                                                            <a href="{{ route('divisions.index') }}"
                                                                class="btn btn-secondary ms-2">Hapus Filter</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @can('create_divisions')
                                        <a href="{{ route('divisions.create') }}" type="button"
                                            class="btn border-0 p-0 me-3">
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
                                                @if ($showNumbering)
                                                    <th>No.</th>
                                                @endif
                                                @foreach ($visibleColumns as $column)
                                                    <th>{{ ucfirst(str_replace('_', ' ', $column)) }}</th>
                                                @endforeach
                                                @if (Auth::user()->can('edit_divisions') || Auth::user()->can('delete_divisions'))
                                                    <th>Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($divisions as $division)
                                                <tr>
                                                    @if ($showNumbering)
                                                        <td class="text-bold-500">{{ $loop->iteration }}</td>
                                                    @endif
                                                    @foreach ($visibleColumns as $column)
                                                        <td>{{ $division->{$column} }}</td>
                                                    @endforeach
                                                    @if (Auth::user()->can('edit_divisions') || Auth::user()->can('delete_divisions'))
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                @can('edit_divisions')
                                                                    <a href="{{ route('divisions.edit', $division->id) }}"
                                                                        class="btn btn-sm btn-outline-warning">
                                                                        <i class="bx bx-edit"></i>
                                                                    </a>
                                                                @endcan
                                                                @can('delete_divisions')
                                                                    <form method="POST"
                                                                        action="{{ route('divisions.destroy', $division->id) }}">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-outline-danger"
                                                                            id="delete-btn">
                                                                            <i class="bx bx-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                @endcan
                                                            </div>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-center"
                                                        colspan="{{ count($visibleColumns) + ($showNumbering ? 2 : 1) }}">
                                                        Tidak Ada Divisi
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        {{ $divisions->withQueryString()->links() }}
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
        const deleteButtons = document.querySelectorAll('#delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan bisa mengembalikannya!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    customClass: {
                        confirmButton: 'btn btn-primary mx-1',
                        cancelButton: 'btn btn-danger mx-1'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        let errorMessages = @json($errors->all());
        console.log(errorMessages);

        @if ($errors->any())
            errorMessages.forEach((error) => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: error,
                    showConfirmButton: false,
                    timer: 3000
                });
            });
        @endif

        @if (session('error'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Oops, ada yang salah...',
                showConfirmButton: false,
                timer: 3000
            });
        @endif

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
    </script>
@endpush
