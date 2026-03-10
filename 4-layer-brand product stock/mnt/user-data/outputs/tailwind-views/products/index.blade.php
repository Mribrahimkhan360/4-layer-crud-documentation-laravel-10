@extends('layouts.app')
@section('title', 'Products')
@section('subtitle', 'Manage all products by brand')

@section('header-action')
<a href="{{ route('products.create') }}"
   class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-md shadow-brand-600/30 transition-all duration-200 hover:scale-105">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
    </svg>
    Add Product
</a>
@endsection

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center">
            <svg class="w-6 h-6 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-slate-800">{{ $products->count() }}</p>
            <p class="text-xs text-slate-500 font-medium">Total Products</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center">
            <svg class="w-6 h-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-slate-800">{{ $products->pluck('brand_id')->unique()->count() }}</p>
            <p class="text-xs text-slate-500 font-medium">Brands Covered</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-cyan-50 flex items-center justify-center">
            <svg class="w-6 h-6 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-slate-800">{{ $products->sum('stocks_count') }}</p>
            <p class="text-xs text-slate-500 font-medium">Total Stock Items</p>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <p class="font-semibold text-slate-700 text-sm">All Products</p>
        <span class="text-xs text-slate-400 bg-slate-100 px-2.5 py-1 rounded-full">{{ $products->count() }} records</span>
    </div>

    @if($products->isEmpty())
    <div class="py-20 text-center">
        <div class="w-16 h-16 rounded-2xl bg-slate-100 mx-auto flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
        </div>
        <p class="text-slate-500 font-medium text-sm">No products yet</p>
        <p class="text-slate-400 text-xs mt-1">Start by adding your first product.</p>
        <a href="{{ route('products.create') }}" class="mt-4 inline-flex items-center gap-1.5 text-brand-600 text-sm font-semibold hover:underline">
            + Add Product
        </a>
    </div>
    @else
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-100">
                <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider w-12">#</th>
                <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Product</th>
                <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Brand</th>
                <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Stock</th>
                <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Added</th>
                <th class="text-right px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach($products as $product)
            <tr class="hover:bg-slate-50/60 transition-colors duration-150">
                <td class="px-6 py-4 text-slate-400 text-xs font-mono">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                            </svg>
                        </div>
                        <span class="font-semibold text-slate-700">{{ $product->name }}</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold bg-brand-50 text-brand-700 px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                        {{ $product->brand->name }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full
                        {{ $product->stocks_count > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                        {{ $product->stocks_count }} items
                    </span>
                </td>
                <td class="px-6 py-4 text-slate-400 text-xs">{{ $product->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('products.edit', $product->id) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-brand-600 bg-slate-100 hover:bg-brand-50 px-3 py-1.5 rounded-lg transition-all duration-150">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            Edit
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                              onsubmit="return confirm('Delete product: {{ $product->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-all duration-150">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

@endsection
