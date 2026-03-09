@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 550px;">

    <h2 class="mb-4">Edit Stock Entry</h2>

    <form action="{{ route('stocks.update', $stock->id) }}" method="POST">
        @csrf @method('PUT')

        {{-- Product Select --}}
        <div class="mb-3">
            <label class="form-label">Product <span class="text-danger">*</span></label>
            <select name="product_id" class="form-select @error('product_id') is-invalid @enderror">
                <option value="">-- Select Product --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}"
                        {{ old('product_id', $stock->product_id) == $product->id ? 'selected' : '' }}>
                        {{ $product->brand->name }} — {{ $product->name }}
                    </option>
                @endforeach
            </select>
            @error('product_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Serial Number --}}
        <div class="mb-3">
            <label class="form-label">Serial Number <span class="text-danger">*</span></label>
            <input type="text"
                   name="serial_number"
                   value="{{ old('serial_number', $stock->serial_number) }}"
                   class="form-control @error('serial_number') is-invalid @enderror">
            @error('serial_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update Stock</button>
            <a href="{{ route('stocks.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

</div>
@endsection
