@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 500px;">

    <h2 class="mb-4">Add Brand</h2>

    <form action="{{ route('brands.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Brand Name <span class="text-danger">*</span></label>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="e.g. Apple, Samsung">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Save Brand</button>
            <a href="{{ route('brands.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

</div>
@endsection
