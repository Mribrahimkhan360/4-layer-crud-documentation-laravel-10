@extends('layouts.app')

@section('title', 'Edit Order #' . str_pad($order->id, 5, '0', STR_PAD_LEFT))

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-2xl mx-auto">

        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('orders.index') }}"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 mb-4 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Orders
            </a>
            <h1 class="text-3xl font-bold text-gray-900">
                Edit Order <span class="font-mono text-indigo-600">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
            </h1>
            <p class="text-gray-500 mt-1">Update the status or modify the product list.</p>
        </div>

        {{-- Form Card --}}
        <form action="{{ route('orders.update', $order->id) }}" method="POST" id="order-form">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Order Status --}}
                <div class="p-6 border-b border-gray-100">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Order Status
                    </label>
                    <select name="order_status"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-gray-700 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                                   bg-gray-50 capitalize @error('order_status') border-red-400 @enderror">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}"
                                    {{ old('order_status', $order->order_status) === $status ? 'selected' : '' }}
                                    class="capitalize">
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                    @error('order_status')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Products Section --}}
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-sm font-semibold text-gray-700">Products</h2>
                            <p class="text-xs text-gray-400 mt-0.5">Changes here will replace all current products.</p>
                        </div>
                        <button type="button" id="add-product-btn"
                                class="inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-600
                                       hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5
                                       rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Product
                        </button>
                    </div>

                    @error('products')
                        <div class="mb-3 text-red-500 text-xs bg-red-50 border border-red-100 rounded-lg px-3 py-2">
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- Product Rows --}}
                    <div id="products-container" class="space-y-3">

                        @php
                            // On validation fail use old(), otherwise use DB data
                            $productsToShow = old('products')
                                ? collect(old('products'))->map(fn($p) => (object)$p)
                                : $order->orderDetails;
                        @endphp

                        @foreach($productsToShow as $i => $product)
                            <div class="product-row flex items-start gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Product Name</label>
                                    <input type="text"
                                           name="products[{{ $i }}][product_name]"
                                           value="{{ $product->product_name ?? '' }}"
                                           placeholder="e.g. Wireless Mouse"
                                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700
                                                  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                                                  @error('products.'.$i.'.product_name') border-red-400 @enderror">
                                    @error('products.'.$i.'.product_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="w-32">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Quantity</label>
                                    <input type="number"
                                           name="products[{{ $i }}][product_quantity]"
                                           value="{{ $product->product_quantity ?? 1 }}"
                                           min="1"
                                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700
                                                  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                                                  @error('products.'.$i.'.product_quantity') border-red-400 @enderror">
                                    @error('products.'.$i.'.product_quantity')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="pt-6">
                                    <button type="button"
                                            class="remove-row p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition"
                                            style="{{ $loop->first && $loop->last ? 'visibility:hidden' : '' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                {{-- Footer Actions --}}
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                    <a href="{{ route('orders.show', $order->id) }}"
                       class="text-sm text-gray-500 hover:text-gray-700 underline-offset-2 hover:underline transition">
                        View Order Details
                    </a>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('orders.index') }}"
                           class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 hover:text-gray-800
                                  bg-white border border-gray-200 hover:bg-gray-100 transition">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-indigo-600
                                       hover:bg-indigo-700 shadow transition">
                            Save Changes
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- JS: Dynamic product rows --}}
<script>
    let rowIndex = {{ $productsToShow->count() }};

    document.getElementById('add-product-btn').addEventListener('click', function () {
        const container = document.getElementById('products-container');
        const row = document.createElement('div');
        row.classList.add('product-row', 'flex', 'items-start', 'gap-3', 'p-4', 'bg-gray-50', 'rounded-xl', 'border', 'border-gray-100');
        row.innerHTML = `
            <div class="flex-1">
                <label class="block text-xs font-medium text-gray-500 mb-1">Product Name</label>
                <input type="text"
                       name="products[${rowIndex}][product_name]"
                       placeholder="e.g. Wireless Mouse"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
            <div class="w-32">
                <label class="block text-xs font-medium text-gray-500 mb-1">Quantity</label>
                <input type="number"
                       name="products[${rowIndex}][product_quantity]"
                       value="1" min="1"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
            <div class="pt-6">
                <button type="button"
                        class="remove-row p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>`;
        container.appendChild(row);
        rowIndex++;
        updateRemoveButtons();
    });

    document.getElementById('products-container').addEventListener('click', function (e) {
        const btn = e.target.closest('.remove-row');
        if (!btn) return;
        if (document.querySelectorAll('.product-row').length > 1) {
            btn.closest('.product-row').remove();
            updateRemoveButtons();
        }
    });

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.product-row');
        rows.forEach(row => {
            const btn = row.querySelector('.remove-row');
            btn.style.visibility = rows.length === 1 ? 'hidden' : 'visible';
        });
    }
</script>
@endsection
