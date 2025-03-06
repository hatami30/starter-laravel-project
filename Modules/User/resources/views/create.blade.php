@extends('admin.layouts.app')

@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Tambah Pengguna</h3>
                        <p class="text-subtitle text-muted">Buat akun pengguna baru.</p>
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
                                <form method="POST" action="{{ route('users.store') }}">
                                    @csrf

                                    <!-- Pemilihan Peran -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="role_id">Peran</label>
                                        <select class="form-select @error('role_id') is-invalid @enderror" id="role_id"
                                            name="role_id">
                                            <option value="" selected>Pilih peran...</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                    {{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Nama -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="name">Nama</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" placeholder="Masukkan nama"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Username -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                                            id="username" name="username"
                                            placeholder="Masukkan username"value="{{ old('username') }}" required>
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" placeholder="Masukkan email"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Telepon -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="phone">Telepon</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" placeholder="Masukkan telepon"
                                            value="{{ old('phone') }}">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Divisi -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="division_id">Divisi</label>
                                        <select class="form-select @error('division_id') is-invalid @enderror"
                                            id="division_id" name="division_id">
                                            <option value="" selected>Pilih divisi...</option>
                                            @foreach ($divisions as $division)
                                                <option value="{{ $division->id }}"
                                                    {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                                    {{ $division->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('division_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="status">Status</label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status"
                                            name="status">
                                            <option value="" selected>Pilih status...</option>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                                Aktif</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                                Tidak Aktif</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="password">Kata Sandi</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" placeholder="Masukkan kata sandi" name="password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="reset"
                                                class="btn btn-light-secondary me-1 mb-1">Reset</button>
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
