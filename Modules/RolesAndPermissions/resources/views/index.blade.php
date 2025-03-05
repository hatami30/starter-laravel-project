@extends('admin.layouts.app')

@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Peran dan Izin</h3>
                        <p class="text-subtitle text-muted">Kelola peran, izin, dan level akses.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Dasar mulai -->
        <section class="section">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-content">
                            <div class="card-header d-flex justify-content-end align-items-center">

                                <div class="d-flex align-items-center">
                                    <!-- Tombol Modal Pengaturan Tabel -->
                                    <button type="button" class="btn border-0 p-0 me-3" data-bs-toggle="modal"
                                        data-bs-target="#tableSettingsModal">
                                        <i class='bx bx-sm bx-cog'></i>
                                    </button>

                                    <!-- Modal untuk Pengaturan Tabel -->
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
                                                        action="{{ route('roles.and.permissions.save.table.settings') }}">
                                                        @csrf
                                                        <!-- Visibilitas Kolom -->
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

                                                        <!-- Opsi Tampilkan Nomor Baris -->
                                                        <h6 class="fw-bold mt-4">Tampilkan Nomor Baris</h6>
                                                        <p class="text-muted">Aktifkan opsi ini untuk menampilkan nomor
                                                            baris di sampingnya.</p>
                                                        <div class="form-check form-switch mt-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="show_numbering" id="show_numbering"
                                                                @if (old('show_numbering') || ($savedSettings->show_numbering ?? false)) checked @endif>
                                                            <label class="form-check-label" for="show_numbering">Tampilkan
                                                                Nomor Baris</label>
                                                        </div>

                                                        <!-- Dropdown Limit -->
                                                        <div class="form-group my-4">
                                                            <h6 for="limit" class="fw-bold mt-4">Item per Halaman (Batas)
                                                            </h6>
                                                            <p class="text-muted">Pilih berapa banyak item yang akan
                                                                ditampilkan per halaman di tabel.</p>
                                                            <select name="limit" class="form-select">
                                                                @foreach ([5, 10, 20, 50, 100] as $limit)
                                                                    <option value="{{ $limit }}"
                                                                        {{ (old('limit') ?: $savedSettings->limit ?? 10) == $limit ? 'selected' : '' }}>
                                                                        {{ $limit }} item
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Tombol Simpan -->
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

                                    <!-- Modal untuk Filter Tabel -->
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
                                                    <form method="GET"
                                                        action="{{ route('roles.and.permissions.index') }}">
                                                        <!-- Input Pencarian -->
                                                        <div class="mb-3">
                                                            <label for="search" class="fw-bold">Cari:</label>
                                                            <input type="text" class="form-control" placeholder="Cari"
                                                                name="q" value="{{ request('q') }}" />
                                                        </div>

                                                        <!-- Dropdown Limit -->
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

                                                        <!-- Dropdown Urutkan Berdasarkan -->
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

                                                        <!-- Dropdown Urutan -->
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

                                                        <!-- Dropdown Filter Role -->
                                                        <div class="mb-3">
                                                            <label for="role" class="fw-bold">Peran:</label>
                                                            <select name="role" class="form-select">
                                                                <option value="">Semua Peran</option>
                                                                <!-- Opsi tanpa filter role -->
                                                                @foreach ($roles as $role)
                                                                    <option value="{{ $role->name }}"
                                                                        {{ request('role') == $role->name ? 'selected' : '' }}>
                                                                        {{ ucfirst($role->name) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Tombol untuk Terapkan Filter dan Bersihkan Filter -->
                                                        <div class="d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary">
                                                                Terapkan Filter
                                                            </button>
                                                            <a href="{{ route('roles.and.permissions.index') }}"
                                                                class="btn btn-secondary ms-2">
                                                                Hapus Filter
                                                            </a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tombol Pengguna Baru -->
                                    @can('create_roles_and_permissions', $roles)
                                        <a href="{{ route('roles.and.permissions.create') }}" type="button"
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
                                                @if ($savedSettings->show_numbering ?? false)
                                                    <th>No.</th>
                                                @endif
                                                @foreach ($visibleColumns as $visibleColumn)
                                                    <th>{{ ucfirst(str_replace('_', ' ', $visibleColumn)) }}</th>
                                                @endforeach
                                                @if (Auth::user()->can('edit_roles_and_permissions') || Auth::user()->can('delete_roles_and_permissions'))
                                                    <th>Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($roles as $role)
                                                <tr>
                                                    @if ($savedSettings->show_numbering ?? false)
                                                        <td class="text-bold-500">{{ $loop->iteration }}</td>
                                                    @endif
                                                    @foreach ($visibleColumns as $column)
                                                        <td>
                                                            @if ($column === 'permissions' && is_array($role->permissions))
                                                                @foreach ($role->permissions as $permission)
                                                                    <span
                                                                        class="badge bg-primary my-1">{{ $permission }}</span>
                                                                @endforeach
                                                            @else
                                                                {{ is_array($role->{$column}) ? implode(', ', $role->{$column}) : $role->{$column} }}
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                    @if (Auth::user()->can('edit_roles_and_permissions') || Auth::user()->can('delete_roles_and_permissions'))
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                @can('edit_roles_and_permissions', $role)
                                                                    <a href="{{ route('roles.and.permissions.edit', $role->id) }}"
                                                                        class="btn btn-sm btn-outline-warning d-flex justify-content-center align-items-center p-0"
                                                                        style="width: 36px; height: 36px;">
                                                                        <i class="bx bx-edit"></i>
                                                                    </a>
                                                                @endcan
                                                                @can('delete_roles_and_permissions', $role)
                                                                    <form method="POST"
                                                                        action="{{ route('roles.and.permissions.destroy', $role->id) }}">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-outline-danger d-flex justify-content-center align-items-center p-0"
                                                                            style="width: 36px; height: 36px;"
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
                                                    <td colspan="{{ count($visibleColumns) + 2 }}" class="text-center">
                                                        Tidak ada peran ditemukan.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                {{ $roles->links() }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- Tabel Dasar selesai -->
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
                    text: "Anda tidak akan bisa membatalkan ini!",
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
                title: 'Oops, terjadi kesalahan...',
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
