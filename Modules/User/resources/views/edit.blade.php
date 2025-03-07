@extends('admin.layouts.app')

@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Ubah Pengguna</h3>
                        <p class="text-subtitle text-muted">Perbarui informasi akun pengguna.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulir Edit Pengguna Mulai -->
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form method="POST" action="{{ route('users.update', $user->id) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="role_id">Peran</label>
                                        <select name="role_id" id="role_id"
                                            class="form-select @error('role_id') is-invalid @enderror">
                                            <option value="" disabled>Pilih peran...</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ old('role_id', $user->roles->pluck('id')->first()) == $role->id ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="name">Nama</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" placeholder="Masukkan nama"
                                            value="{{ old('name', $user->name) }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                                            id="username" name="username" placeholder="Masukkan username"
                                            value="{{ old('username', $user->username) }}">
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', $user->email) }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Field Telepon -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="phone">Telepon</label>
                                        <div class="input-group">
                                            <span class="input-group-text">+62</span>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                id="phone" name="phone" placeholder="8123456789"
                                                value="{{ old('phone', $user->phone) }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" pattern="[0-9]*"
                                                inputmode="numeric">
                                        </div>
                                        <small class="text-muted">Masukkan nomor tanpa angka 0 di depan (contoh:
                                            8123456789)</small>
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Field Divisi -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="division_id">Divisi</label>
                                        <select name="division_id" id="division_id"
                                            class="form-select @error('division_id') is-invalid @enderror">
                                            <option value="" disabled>Pilih divisi...</option>
                                            @foreach ($divisions as $division)
                                                <option value="{{ $division->id }}"
                                                    {{ old('division_id', $user->division_id) == $division->id ? 'selected' : '' }}>
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

                                    <!-- Field Status -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="status">Status</label>
                                        <select name="status" id="status"
                                            class="form-select @error('status') is-invalid @enderror">
                                            <option value="" disabled>Pilih status...</option>
                                            <option value="active"
                                                {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>
                                                Aktif
                                            </option>
                                            <option value="inactive"
                                                {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>
                                                Tidak Aktif
                                            </option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Field Kata Sandi -->
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="password">Kata Sandi</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" placeholder="Masukkan kata sandi" name="password">
                                        <span class="text-muted small">(Kosongkan jika tidak mengubah kata sandi)</span>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a href="{{ route('users.index') }}"
                                                class="btn btn-light-secondary me-1 mb-1">Batal</a>
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Perbarui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Formulir Edit Pengguna Selesai -->
    </div>
@endsection
