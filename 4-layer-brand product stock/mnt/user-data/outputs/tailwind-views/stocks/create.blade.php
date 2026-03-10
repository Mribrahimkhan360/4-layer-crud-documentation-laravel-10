@extends('layouts.app')
@section('title', 'Add Stock')
@section('subtitle', 'Assign serial numbers to a product')

@section('header-action')
<a href="{{ route('stocks.index') }}"
   class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-800 bg-white border border-slate-200 hover:border-slate-300 text-sm font-medium px-4 py-2.5 rounded-xl transition-all duration-200">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    Back to Stock
</a>
@endsection

@section('content')
<div class="max-w-xl">

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

        {{-- Card Header --}}
        <div class="px-7 py-5 border-b border-slate-100 bg-gradient-to-r from-brand-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-brand-600 flex items-center justify-center shadow-md shadow-brand-600/30">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-slate-800 text-sm">Add Stock Entries</p>
                    <p class="text-xs text-slate-500">Select a product and enter serial numbers</p>
                </div>
            </div>
        </div>

        <form action="{{ route('stocks.store') }}" method="POST" class="px-7 py-6 space-y-6">
            @csrf

            {{-- Product Select --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                    Product <span class="text-red-500 normal-case tracking-normal">*</span>
                </label>
                <div class="relative">
                    <select
                        name="product_id"
                        class="w-full appearance-none px-4 py-3 pr-10 rounded-xl border text-sm text-slate-700 outline-none transition-all duration-200
                               {{ $errors->has('product_id') ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-200' : 'border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-400 focus:ring-2 focus:ring-brand-100' }}">
                        <option value="">— Select Product —</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->brand->name }} — {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
                @error('product_id')
                    <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Serial Numbers --}}
            <div>
                <div class="flex items-center justify-between mb-3">
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider">
                        Serial Numbers <span class="text-red-500 normal-case tracking-normal">*</span>
                    </label>
                    <span id="serial-counter" class="text-xs text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full font-medium">1 entry</span>
                </div>

                <div id="serial-list" class="space-y-2.5">

                    @if(old('serial_numbers'))
                        @foreach(old('serial_numbers') as $i => $sn)
                        <div class="serial-row flex items-start gap-2">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 bg-slate-50 border {{ $errors->has('serial_numbers.'.$i) ? 'border-red-400' : 'border-slate-200' }} rounded-xl px-3 py-2.5 focus-within:border-brand-400 focus-within:ring-2 focus-within:ring-brand-100 focus-within:bg-white transition-all duration-200">
                                    <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                    </svg>
                                    <input type="text" name="serial_numbers[]" value="{{ $sn }}"
                                           class="flex-1 bg-transparent text-sm text-slate-700 placeholder-slate-400 outline-none font-mono tracking-wide"
                                           placeholder="e.g. SN-000{{ $i + 1 }}">
                                </div>
                                @error('serial_numbers.'.$i)
                                    <p class="mt-1 text-xs text-red-500 flex items-center gap-1 pl-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <button type="button" onclick="removeSerial(this)"
                                class="btn-remove mt-0.5 w-9 h-9 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all duration-150 flex-shrink-0"
                                style="display:none">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        @endforeach
                    @else
                    <div class="serial-row flex items-start gap-2">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 focus-within:border-brand-400 focus-within:ring-2 focus-within:ring-brand-100 focus-within:bg-white transition-all duration-200">
                                <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                                <input type="text" name="serial_numbers[]"
                                       class="flex-1 bg-transparent text-sm text-slate-700 placeholder-slate-400 outline-none font-mono tracking-wide"
                                       placeholder="e.g. SN-00001" autofocus>
                            </div>
                        </div>
                        <button type="button" onclick="removeSerial(this)"
                            class="btn-remove mt-0.5 w-9 h-9 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all duration-150 flex-shrink-0"
                            style="display:none">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    @endif
                </div>

                {{-- Add more button --}}
                <button type="button" onclick="addSerial()"
                    class="mt-3 w-full flex items-center justify-center gap-2 border-2 border-dashed border-slate-200 hover:border-brand-400 hover:bg-brand-50 text-slate-500 hover:text-brand-600 text-sm font-semibold py-2.5 rounded-xl transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Another Serial Number
                </button>
            </div>

            <div class="flex items-center gap-3 pt-1">
                <button type="submit"
                    class="flex-1 inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold text-sm py-3 rounded-xl shadow-md shadow-brand-600/30 transition-all duration-200 hover:scale-[1.02]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Stock Entries
                </button>
                <a href="{{ route('stocks.index') }}"
                   class="px-5 py-3 text-sm font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
    let count = document.querySelectorAll('.serial-row').length;

    function addSerial() {
        const list = document.getElementById('serial-list');
        count++;
        const row = document.createElement('div');
        row.className = 'serial-row flex items-start gap-2';
        row.innerHTML = `
            <div class="flex-1">
                <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 focus-within:border-indigo-400 focus-within:ring-2 focus-within:ring-indigo-100 focus-within:bg-white transition-all duration-200">
                    <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                    </svg>
                    <input type="text" name="serial_numbers[]"
                           class="flex-1 bg-transparent text-sm text-slate-700 placeholder-slate-400 outline-none font-mono tracking-wide"
                           placeholder="e.g. SN-0000${count}">
                </div>
            </div>
            <button type="button" onclick="removeSerial(this)"
                class="btn-remove mt-0.5 w-9 h-9 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all duration-150 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        `;
        list.appendChild(row);
        row.querySelector('input').focus();
        updateUI();
        // Animate in
        row.style.opacity = '0';
        row.style.transform = 'translateY(-6px)';
        requestAnimationFrame(() => {
            row.style.transition = 'opacity 0.2s, transform 0.2s';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        });
    }

    function removeSerial(btn) {
        const rows = document.querySelectorAll('.serial-row');
        if (rows.length > 1) {
            const row = btn.closest('.serial-row');
            row.style.transition = 'opacity 0.15s, transform 0.15s';
            row.style.opacity = '0';
            row.style.transform = 'translateX(10px)';
            setTimeout(() => { row.remove(); updateUI(); }, 150);
        }
    }

    function updateUI() {
        const rows = document.querySelectorAll('.serial-row');
        const c = rows.length;
        rows.forEach(row => {
            const btn = row.querySelector('.btn-remove');
            btn.style.display = c > 1 ? 'flex' : 'none';
        });
        const counter = document.getElementById('serial-counter');
        counter.textContent = c + (c === 1 ? ' entry' : ' entries');
    }

    document.addEventListener('DOMContentLoaded', updateUI);
</script>
@endpush
@endsection
