@extends('admin.layouts.app')

@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Risiko</h3>
                        <p class="text-subtitle text-muted">Lihat dan kelola semua risiko.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Basic Tables start -->
        <section class="section">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-content">
                            <div class="card-header d-flex justify-content-end align-items-center">

                                <div class="d-flex align-items-center">
                                    <!-- Cog Icon as Modal Button -->
                                    <button type="button" class="btn border-0 p-0 me-3" data-bs-toggle="modal"
                                        data-bs-target="#tableSettingsModal">
                                        <i class='bx bx-sm bx-cog'></i>
                                    </button>

                                    <!-- Modal for Table Settings -->
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
                                                    <form method="POST" action="{{ route('risks.save.table.settings') }}">
                                                        @csrf
                                                        <!-- Columns Visibility -->
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

                                                        <!-- Show Numbering Option -->
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

                                                        <!-- Limit Dropdown -->
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

                                                        <!-- Save Button -->
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

                                    <!-- Modal for Filters -->
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
                                                    <form method="GET" action="{{ route('risks.index') }}">
                                                        <!-- Search Input -->
                                                        <div class="mb-3">
                                                            <label for="search" class="fw-bold">Cari:</label>
                                                            <input type="text" class="form-control" placeholder="Cari"
                                                                name="q" value="{{ request('q') }}" />
                                                        </div>

                                                        <!-- Limit Dropdown -->
                                                        <div class="mb-3">
                                                            <label for="limit" class="fw-bold">Batas:</label>
                                                            <select name="limit" class="form-select">
                                                                @foreach ($limits as $limit)
                                                                    <option value="{{ $limit }}"
                                                                        {{ (request('limit') ?: $savedSettings->limit ?? 10) == $limit ? 'selected' : '' }}>
                                                                        {{ $limit }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Sort By Dropdown -->
                                                        <div class="mb-3">
                                                            <label for="sort_by" class="fw-bold">Urutkan
                                                                Berdasarkan:</label>
                                                            <select name="sort_by" class="form-select">
                                                                @foreach ($visibleColumns as $column)
                                                                    @if (!in_array($column, $excludedSortColumns))
                                                                        <option value="{{ $column }}"
                                                                            {{ request('sort_by') == $column ? 'selected' : '' }}>
                                                                            {{ ucfirst($column) }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Order Dropdown -->
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

                                                        <!-- Role Filter Dropdown -->
                                                        <div class="mb-3">
                                                            <label for="role" class="fw-bold">Peran:</label>
                                                            <select name="role" class="form-select">
                                                                <option value="">Semua Peran</option>
                                                                @foreach ($roles as $role)
                                                                    <option value="{{ $role->name }}"
                                                                        {{ request('role') == $role->name ? 'selected' : '' }}>
                                                                        {{ ucfirst($role->name) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Buttons for Apply Filters and Clear Filters -->
                                                        <div class="d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary">
                                                                Terapkan Filter
                                                            </button>
                                                            <a href="{{ route('risks.index') }}"
                                                                class="btn btn-secondary ms-2">
                                                                Hapus Filter
                                                            </a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- New Risk Button -->
                                    @can('create_risks', $risks)
                                        <a href="{{ route('risks.create') }}" type="button" class="btn border-0 p-0 me-3">
                                            <i class='bx bx-sm bx-plus-circle'></i>
                                        </a>
                                    @endcan

                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Table with outer spacing -->
                                <div class="table-responsive">
                                    <table class="table table-lg">
                                        <thead>
                                            <tr>
                                                @if ($savedSettings->show_numbering ?? false)
                                                    <th>No.</th>
                                                @endif
                                                @foreach ($visibleColumns as $visibleColumn)
                                                    <th>{{ ucfirst(str_replace('_', ' ', $visibleColumn)) }}</th>
                                                @endforeach
                                                @if (Auth::user()->can('edit_risks') || Auth::user()->can('delete_risks'))
                                                    <th>Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($risks as $risk)
                                                <tr>
                                                    @if ($savedSettings->show_numbering ?? false)
                                                        <td class="text-bold-500">{{ $loop->iteration }}</td>
                                                    @endif
                                                    @foreach ($visibleColumns as $column)
                                                        <td>
                                                            {{ is_array($risk->{$column}) ? implode(', ', $risk->{$column}) : $risk->{$column} }}
                                                        </td>
                                                    @endforeach
                                                    <td>
                                                        <!-- Active Status -->
                                                        @if (Auth::user()->can('edit_risks') || Auth::user()->can('delete_risks'))
                                                            <div class="d-flex gap-2">
                                                                @can('edit_risks', $risk)
                                                                    <a href="{{ route('risks.edit', $risk->id) }}"
                                                                        class="btn btn-sm btn-outline-warning d-flex justify-content-center align-items-center p-0"
                                                                        style="width: 36px; height: 36px;">
                                                                        <i class="bx bx-edit"></i>
                                                                    </a>
                                                                @endcan
                                                                @can('delete_risks', $risk)
                                                                    <form method="POST"
                                                                        action="{{ route('risks.destroy', $risk->id) }}"
                                                                        style="margin: 0;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-outline-danger d-flex justify-content-center align-items-center p-0"
                                                                            style="width: 36px; height: 36px;">
                                                                            <i class="bx bx-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                @endcan
                                                            </div>
                                                        @endif
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
                                <!-- Pagination links -->
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        {{ $risks->withQueryString()->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Basic Tables end -->
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
    </script>
@endpush
