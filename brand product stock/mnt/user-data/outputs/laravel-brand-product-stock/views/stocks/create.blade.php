@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px;">

    <h2 class="mb-4">Add Stock</h2>

    <form action="{{ route('stocks.store') }}" method="POST">
        @csrf

        {{-- Product Select --}}
        <div class="mb-3">
            <label class="form-label">Product <span class="text-danger">*</span></label>
            <select name="product_id" class="form-select @error('product_id') is-invalid @enderror">
                <option value="">-- Select Product --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->brand->name }} — {{ $product->name }}
                    </option>
                @endforeach
            </select>
            @error('product_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Serial Numbers --}}
        <div class="mb-3">
            <label class="form-label">Serial Numbers <span class="text-danger">*</span></label>
            <div id="serial-list">

                {{-- Repopulate on validation error --}}
                @if(old('serial_numbers'))
                    @foreach(old('serial_numbers') as $i => $sn)
                    <div class="input-group mb-2 serial-row">
                        <input type="text"
                               name="serial_numbers[]"
                               value="{{ $sn }}"
                               class="form-control @error('serial_numbers.'.$i) is-invalid @enderror"
                               placeholder="e.g. SN-00001">
                        @error('serial_numbers.'.$i)
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <button type="button" class="btn btn-outline-danger btn-remove" onclick="removeSerial(this)">✕</button>
                    </div>
                    @endforeach
                @else
                    {{-- Default: one empty row --}}
                    <div class="input-group mb-2 serial-row">
                        <input type="text" name="serial_numbers[]" class="form-control" placeholder="e.g. SN-00001">
                        <button type="button" class="btn btn-outline-danger btn-remove" onclick="removeSerial(this)" style="display:none;">✕</button>
                    </div>
                @endif

            </div>

            <button type="button" class="btn btn-outline-secondary btn-sm mt-1" onclick="addSerial()">
                + Add Another Serial
            </button>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary">Save Stock</button>
            <a href="{{ route('stocks.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

</div>

@push('scripts')
<script>
    function addSerial() {
        const list = document.getElementById('serial-list');
        const row  = document.createElement('div');
        row.className = 'input-group mb-2 serial-row';
        row.innerHTML = `
            <input type="text" name="serial_numbers[]" class="form-control" placeholder="e.g. SN-00001">
            <button type="button" class="btn btn-outline-danger btn-remove" onclick="removeSerial(this)">✕</button>
        `;
        list.appendChild(row);
        updateRemoveButtons();
        row.querySelector('input').focus();
    }

    function removeSerial(btn) {
        const rows = document.querySelectorAll('.serial-row');
        if (rows.length > 1) {
            btn.closest('.serial-row').remove();
            updateRemoveButtons();
        }
    }

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.serial-row');
        rows.forEach(row => {
            const btn = row.querySelector('.btn-remove');
            btn.style.display = rows.length > 1 ? 'inline-flex' : 'none';
        });
    }

    // Init on load
    document.addEventListener('DOMContentLoaded', updateRemoveButtons);
</script>
@endpush
@endsection
