{{-- resources/views/product-orders/edit.blade.php --}}

<div class="max-w-xl">
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

        {{-- ── Card Header ── --}}
        <div class="px-7 py-5 border-b border-slate-100 bg-gradient-to-r from-brand-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-brand-600 flex items-center justify-center shadow-md shadow-brand-600/30">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-gray-700 text-sm">Edit Order</p>
                    <p class="text-xs text-slate-500">Update the product or quantity</p>
                </div>
            </div>
        </div>

        <form action="{{ route('product-orders.update', $order->id) }}" method="POST"
              class="px-7 py-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- ── Product Select ── --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                    Product <span class="text-red-500 normal-case tracking-normal">*</span>
                </label>
                <div class="relative">
                    <select
                        name="product_id"
                        class="w-full appearance-none px-4 py-3 pr-10 rounded-xl border text-sm
                               text-slate-700 outline-none transition-all duration-200
                               {{ $errors->has('product_id')
                                    ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-200'
                                    : 'border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-400 focus:ring-2 focus:ring-brand-100' }}">
                        <option value="">— Select Product —</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}"
                                {{ old('product_id', $order->product_id) == $product->id ? 'selected' : '' }}>
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
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- ── Quantity ── --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                    Quantity <span class="text-red-500 normal-case tracking-normal">*</span>
                </label>
                <input
                    type="number"
                    name="quantity"
                    value="{{ old('quantity', $order->quantity) }}"
                    min="1"
                    class="w-full px-4 py-3 rounded-xl border text-sm text-slate-700
                           outline-none transition-all duration-200
                           {{ $errors->has('quantity')
                                ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-200'
                                : 'border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-400 focus:ring-2 focus:ring-brand-100' }}"
                    placeholder="Enter quantity">
                @error('quantity')
                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- ── Actions ── --}}
            <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                <button
                    type="submit"
                    class="flex-1 inline-flex items-center justify-center gap-2 bg-brand-600
                           hover:bg-brand-700 text-white font-semibold text-sm py-3 rounded-xl
                           shadow-md shadow-brand-600/30 transition-all duration-200 hover:scale-[1.02]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Order
                </button>
                <a href="{{ route('product-orders.index') }}"
                   class="px-5 py-3 text-sm font-semibold text-slate-600 hover:text-slate-800
                          bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors duration-200">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>
