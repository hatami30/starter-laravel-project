@extends('admin.layouts.app')

@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Edit Division</h3>
                        <p class="text-subtitle text-muted">Update the division information.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Division Edit Form Section -->
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form method="POST" action="{{ route('divisions.update', $division->id) }}">
                                    @csrf
                                    @method('PUT') <!-- Use PUT for updates -->

                                    <!-- Division Name -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="name">Division Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $division->name) }}"
                                            placeholder="Enter division name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Division Description -->
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="description">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            placeholder="Enter division description">{{ old('description', $division->description) }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Status (Optional, if applicable) -->
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="status">Status</label>
                                        <select name="status" id="status"
                                            class="form-select @error('status') is-invalid @enderror">
                                            <option value="active"
                                                {{ old('status', $division->status) == 'active' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="inactive"
                                                {{ old('status', $division->status) == 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Submit & Cancel Buttons -->
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a href="{{ route('divisions.index') }}"
                                                class="btn btn-light-secondary me-1 mb-1">Cancel</a>
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Division Edit Form Section end -->
    </div>
@endsection
