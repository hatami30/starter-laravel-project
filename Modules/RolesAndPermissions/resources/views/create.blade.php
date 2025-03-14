@extends('admin.layouts.app')

@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Peran dan Izin Baru</h3>
                        <p class="text-subtitle text-muted">Buat peran baru dan pilih izin yang diinginkan.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulir Kolom Ganda Dasar mulai -->
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form method="POST" action="{{ route('roles.and.permissions.store') }}">
                                    @csrf

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="role-name">Nama Peran</label>
                                        <input type="text" class="form-control @error('role_name') is-invalid @enderror"
                                            id="role-name" name="role_name" placeholder="Masukkan nama peran"
                                            value="{{ old('role_name') }}">
                                        @error('role_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-4">
                                        <label class="form-label">Izin</label>
                                        <div class="d-flex justify-content-between mb-3 align-items-center">
                                            <!-- Dropdown Aksi Global -->
                                            <div class="dropdown">
                                                <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                                    id="globalActions" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Aksi Global
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="globalActions">
                                                    <li><a class="dropdown-item select-all-global" href="#">Pilih
                                                            Semua</a></li>
                                                    <li><a class="dropdown-item deselect-all-global" href="#">Batalkan
                                                            Pilihan Semua</a></li>
                                                    <li><a class="dropdown-item expand-all" href="#">Perluas Semua</a>
                                                    </li>
                                                    <li><a class="dropdown-item collapse-all" href="#">Liput Semua</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        @foreach ($permissions as $module => $modulePermissions)
                                            <div class="mb-4">
                                                <!-- Header Modul dengan Dropdown -->
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <button class="btn btn-outline-primary text-start w-100" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#module-{{ Str::slug($module) }}"
                                                        aria-expanded="false"
                                                        aria-controls="module-{{ Str::slug($module) }}">
                                                        {{ ucfirst($module) }}
                                                    </button>
                                                    <div class="dropdown ms-2">
                                                        <button class="btn btn-outline-secondary dropdown-toggle"
                                                            type="button" id="moduleActions-{{ Str::slug($module) }}"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            Aksi
                                                        </button>
                                                        <ul class="dropdown-menu"
                                                            aria-labelledby="moduleActions-{{ Str::slug($module) }}">
                                                            <li><a class="dropdown-item select-all-module" href="#"
                                                                    data-module="{{ Str::slug($module) }}">Pilih Semua</a>
                                                            </li>
                                                            <li><a class="dropdown-item deselect-all-module" href="#"
                                                                    data-module="{{ Str::slug($module) }}">Batalkan Pilihan
                                                                    Semua</a></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <!-- Izin yang Bisa Dilipat -->
                                                <div class="collapse mt-3" id="module-{{ Str::slug($module) }}">
                                                    <div class="row">
                                                        @foreach ($modulePermissions as $permission)
                                                            <div class="col-md-3 mb-3">
                                                                <div class="form-check form-switch">
                                                                    <input
                                                                        class="form-check-input permission-checkbox module-{{ Str::slug($module) }}"
                                                                        type="checkbox" name="permissions[]"
                                                                        value="{{ $permission->id }}"
                                                                        id="permission-{{ $permission->id }}"
                                                                        @if (is_array(old('permissions')) && in_array($permission->id, old('permissions'))) checked @endif>
                                                                    <label class="form-check-label"
                                                                        for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
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
        <!-- Formulir Kolom Ganda Dasar selesai -->
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const expandAllBtn = document.querySelector('.expand-all');
            const collapseAllBtn = document.querySelector('.collapse-all');
            const selectAllGlobalBtn = document.querySelector('.select-all-global');
            const deselectAllGlobalBtn = document.querySelector('.deselect-all-global');
            const allCollapsibles = document.querySelectorAll('.collapse');
            const allCheckboxes = document.querySelectorAll('.permission-checkbox');

            // Perluas Semua Modul
            expandAllBtn.addEventListener('click', (e) => {
                e.preventDefault();
                allCollapsibles.forEach(collapse => collapse.classList.add('show'));
            });

            // Liput Semua Modul
            collapseAllBtn.addEventListener('click', (e) => {
                e.preventDefault();
                allCollapsibles.forEach(collapse => collapse.classList.remove('show'));
            });

            // Pilih Semua Izin Secara Global
            selectAllGlobalBtn.addEventListener('click', (e) => {
                e.preventDefault();
                allCheckboxes.forEach(checkbox => checkbox.checked = true);
            });

            // Batalkan Pilihan Semua Izin Secara Global
            deselectAllGlobalBtn.addEventListener('click', (e) => {
                e.preventDefault();
                allCheckboxes.forEach(checkbox => checkbox.checked = false);
            });

            // Pilih Semua Izin untuk Modul
            document.querySelectorAll('.select-all-module').forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const moduleClass = `.module-${button.getAttribute('data-module')}`;
                    document.querySelectorAll(moduleClass).forEach(checkbox => checkbox.checked =
                        true);
                });
            });

            // Batalkan Pilihan Semua Izin untuk Modul
            document.querySelectorAll('.deselect-all-module').forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const moduleClass = `.module-${button.getAttribute('data-module')}`;
                    document.querySelectorAll(moduleClass).forEach(checkbox => checkbox.checked =
                        false);
                });
            });
        });
    </script>
@endpush
