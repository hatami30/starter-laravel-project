@extends('admin.layouts.auth')

@section('content')
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    {{-- <div class="auth-logo">
                        <a href="{{ url()->current() }}"><img src="{{ asset('mazer/assets/static/images/logo/logo.svg') }}" alt="Logo"></a>
                    </div> --}}
                    <h1 class="display-6 fw-bold">Masuk.</h1>
                    <p class="fs-5 text-gray-500 mb-5">Masuk dengan data yang Anda masukkan saat pendaftaran.</p>

                    <form action="{{ route('auth.login') }}" method="POST">
                        @csrf

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="identity"
                                class="form-control form-control-lg @error('identity') is-invalid @enderror"
                                placeholder="Email atau Nama Pengguna" value="{{ old('identity') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            @error('identity')
                                <p class="text-danger fw-bold mt-1" style="font-size: 0.85rem;">
                                    * {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                placeholder="Kata Sandi">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('password')
                                <p class="text-danger fw-bold mt-1" style="font-size: 0.85rem;">
                                    * {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-md shadow-md mt-3 py-2">
                            Masuk
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"></div>
            </div>
        </div>
    </div>
@endsection
