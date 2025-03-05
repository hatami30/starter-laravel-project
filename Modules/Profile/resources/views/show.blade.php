@extends('admin.layouts.app')

@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Profil Akun</h3>
                        <p class="text-subtitle text-muted">Halaman di mana pengguna dapat mengubah informasi profil</p>
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
                                <form method="POST" action="{{ route('update.profile', $user->username) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    {{-- <div class="d-flex justify-content-center align-items-center flex-column">
                                        <div class="avatar avatar-2xl" id="image-container" style="cursor: pointer;">
                                            <img id="profile-image" src="{{ getUserImageProfilePath($user) }}"
                                                alt="Avatar" class="img-thumbnail">
                                            <input type="file" id="image-input" name="image_profile" accept="image/*"
                                                style="display: none;">
                                        </div>

                                        <h3 class="mt-3">{{ $user->name }}</h3>
                                        <p class="text-small">{{ $user->roles->first()->name }}</p>
                                    </div> --}}

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="name">Nama</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $user->name) }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="username">Nama Pengguna</label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                                            id="username" name="username" value="{{ old('username', $user->username) }}">
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

                                    <div class="form-group mb-3">
                                        <label class="form-label" for="password">Kata Sandi</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password">
                                        <span class="text-muted small">(Kosongkan jika tidak mengubah)</span>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a href="{{ route('dashboard.index') }}"
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
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
                title: 'Ups, ada yang salah...',
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

    <script>
        const imageContainer = document.getElementById('image-container');
        const imageInput = document.getElementById('image-input');
        const profileImage = document.getElementById('profile-image');

        imageContainer.addEventListener('click', () => {
            imageInput.click();
        });

        imageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    profileImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('update-profile-btn').addEventListener('click', () => {
            alert('Profil berhasil diperbarui!');
        });
    </script>
@endpush
