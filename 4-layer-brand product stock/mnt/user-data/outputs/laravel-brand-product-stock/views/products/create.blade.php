@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 550px;">

    <h2 class="mb-4">Add Product</h2>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        {{-- Brand Select --}}
        <div class="mb-3">
            <label class="form-label">Brand <span class="text-danger">*</span></label>
            <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror">
                <option value="">-- Select Brand --</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
            @error('brand_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Product Name --}}
        <div class="mb-3">
            <label class="form-label">Product Name <span class="text-danger">*</span></label>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="e.g. iPhone 15 Pro">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Save Product</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

</div>
@endsection
