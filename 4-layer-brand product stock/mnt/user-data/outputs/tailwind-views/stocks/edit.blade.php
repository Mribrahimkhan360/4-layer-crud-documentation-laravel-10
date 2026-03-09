@extends('layouts.app')
@section('title', 'Edit Stock Entry')
@section('subtitle', 'Update serial number details')

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
<div class="max-w-lg">

    {{-- Current Info Card --}}
    <div class="bg-slate-900 rounded-2xl p-5 mb-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
            </svg>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-xs text-slate-400 font-medium mb-0.5">Current Serial Number</p>
            <p class="font-mono font-bold text-white tracking-wide truncate">{{ $stock->serial_number }}</p>
        </div>
        <div class="text-right">
            <p class="text-xs text-slate-400">Product</p>
            <p class="text-sm font-semibold text-white">{{ $stock->product->name }}</p>
            <p class="text-xs text-brand-400">{{ $stock->product->brand->name }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

        {{-- Card Header --}}
        <div class="px-7 py-5 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500 flex items-center justify-center shadow-md shadow-amber-500/30">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-slate-800 text-sm">Edit Stock Entry</p>
                    <p class="text-xs text-slate-500">Update the product or serial number</p>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('stocks.update', $stock->id) }}" method="POST" class="px-7 py-6 space-y-5">
            @csrf @method('PUT')

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
                            <option value="{{ $product->id }}"
                                {{ old('product_id', $stock->product_id) == $product->id ? 'selected' : '' }}>
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

            {{-- Serial Number --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                    Serial Number <span class="text-red-500 normal-case tracking-normal">*</span>
                </label>
                <div class="flex items-center gap-2 bg-slate-50 border {{ $errors->has('serial_number') ? 'border-red-400' : 'border-slate-200' }} rounded-xl px-3 py-2.5 focus-within:border-brand-400 focus-within:ring-2 focus-within:ring-brand-100 focus-within:bg-white transition-all duration-200">
                    <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                    </svg>
                    <input
                        type="text"
                        name="serial_number"
                        value="{{ old('serial_number', $stock->serial_number) }}"
                        class="flex-1 bg-transparent text-sm text-slate-700 placeholder-slate-400 outline-none font-mono tracking-wide">
                </div>
                @error('serial_number')
                    <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="flex-1 inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold text-sm py-3 rounded-xl shadow-md shadow-amber-500/30 transition-all duration-200 hover:scale-[1.02]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Update Stock Entry
                </button>
                <a href="{{ route('stocks.index') }}"
                   class="px-5 py-3 text-sm font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
