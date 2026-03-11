<x-app-layout>
    <x-slot name="title">
        Products
    </x-slot>

    <x-slot name="subtitle">
        Manage all products
    </x-slot>

    <x-slot name="header-action">
        <a href="{{ route('products.create') }}"
           class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-md shadow-brand-600/30 transition-all duration-200 hover:scale-105">
            + Add Product
        </a>
    </x-slot>

    <div class="space-y-6">

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div>
{{--                    <p class="text-2xl font-bold text-slate-800">{{ $brands->count() }}</p>--}}
                    <p class="text-xs text-slate-500 font-medium">Total Brands</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800">{{ $products->count() }}</p>
                    <p class="text-xs text-slate-500 font-medium">Total Products</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800">{{ $products->where('stocks_count', '>', 0)->count() }}</p>
                    <p class="text-xs text-slate-500 font-medium">In Stock</p>
                </div>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded-lg">{{ session('success') }}</div>
        @endif

        {{-- Products Table --}}
        <div class="bg-white rounded-2xl border border-slate-200 overflow-x-auto shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <p class="font-semibold text-slate-700 text-sm">All Products</p>

                <a href="{{ route('products.create') }}"
                   class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-gray-600 text-sm font-semibold px-4 py-2.5 rounded-xl shadow-md shadow-brand-600/30 transition-all duration-200 hover:scale-105">
                    + Add Product
                </a>
            </div>



            @if($products->isEmpty())
                <div class="py-20 text-center space-y-2">
                    <div class="w-16 h-16 rounded-2xl bg-slate-100 mx-auto flex items-center justify-center">
                        <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <p class="text-slate-500 font-medium text-sm">No products found</p>
                    <p class="text-slate-400 text-xs">Start by adding your first product.</p>
                    <a href="{{ route('products.create') }}" class="inline-flex items-center gap-1.5 text-brand-600 text-sm font-semibold hover:underline">
                        + Add Product
                    </a>
                </div>
            @else
                <table class="w-full text-sm divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                    <tr>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider w-12">#</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Brand</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Product Name</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Stock Count</th>
                        <th class="text-right px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                    @foreach($products as $product)
                        <tr class="hover:bg-slate-50 transition-colors duration-150">
                            <td class="px-6 py-4 text-slate-400 text-xs font-mono">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4">{{ $product->brand->name }}</td>
                            <td class="px-6 py-4">{{ $product->name }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full
                                    {{ $product->stocks_count > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $product->stocks_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end gap-2">
                                <a href="{{ route('products.edit', $product->id) }}"
                                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-brand-600 bg-slate-100 hover:bg-brand-50 px-3 py-1.5 rounded-lg transition-all duration-150">
                                    Edit
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete product: {{ $product->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-all duration-150">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
</x-app-layout>
