@extends('admin.layouts.app')

@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Edit Divisi</h3>
                        <p class="text-subtitle text-muted">Perbarui informasi divisi.</p>
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
                                <form method="POST" action="{{ route('divisions.update', $division->id) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="name">Nama Divisi</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $division->name) }}"
                                            placeholder="Masukkan nama divisi">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label" for="description">Deskripsi</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            placeholder="Masukkan deskripsi divisi">{{ old('description', $division->description) }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a href="{{ route('divisions.index') }}"
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
