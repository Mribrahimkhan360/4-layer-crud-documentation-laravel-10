{{-- resources/views/product-orders/create.blade.php --}}

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

        {{-- ── Card Header ── --}}
        <div class="px-7 py-5 border-b border-slate-100 bg-gradient-to-r from-brand-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-brand-600 flex items-center justify-center shadow-md shadow-brand-600/30">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-gray-700 text-sm">Create Product Orders</p>
                    <p class="text-xs text-slate-500">Select products and enter quantities</p>
                </div>
            </div>
        </div>

        <form action="{{ route('product-orders.store') }}" method="POST" class="px-7 py-6 space-y-4">
            @csrf

            {{-- ── Table Header ── --}}
            <div class="grid grid-cols-12 gap-3 px-1">
                <div class="col-span-1">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">#</span>
                </div>
                <div class="col-span-7">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Product <span class="text-red-400">*</span>
                    </span>
                </div>
                <div class="col-span-3">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Qty <span class="text-red-400">*</span>
                    </span>
                </div>
                <div class="col-span-1"></div>
            </div>

            {{-- ── Row Container ── --}}
            <div id="order-container" class="space-y-2">

                {{-- ══ Static first row ══ --}}
                <div class="order-row grid grid-cols-12 gap-3 items-start">

                    {{-- Row Number --}}
                    <div class="col-span-1 flex items-center h-[46px]">
                        <span class="row-number text-xs font-bold text-slate-400 bg-slate-100
                                     w-7 h-7 rounded-lg flex items-center justify-center">
                            1
                        </span>
                    </div>

                    {{-- Product Select --}}
                    <div class="col-span-7">
                        <div class="relative">
                            <select
                                name="product_id[]"
                                class="w-full appearance-none px-3 py-2.5 pr-8 rounded-xl border text-sm
                                       text-slate-700 outline-none transition-all duration-200
                                       {{ $errors->has('product_id.0')
                                            ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-200'
                                            : 'border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-400 focus:ring-2 focus:ring-brand-100' }}">
                                <option value="">— Select Product —</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ old('product_id.0') == $product->id ? 'selected' : '' }}>
                                        {{ $product->brand->name }} — {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        @error('product_id.0')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- Quantity --}}
                    <div class="col-span-3">
                        <input
                            type="number"
                            name="quantity[]"
                            value="{{ old('quantity.0') }}"
                            min="1"
                            class="w-full px-3 py-2.5 rounded-xl border text-sm text-slate-700
                                   outline-none transition-all duration-200
                                   {{ $errors->has('quantity.0')
                                        ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-200'
                                        : 'border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-400 focus:ring-2 focus:ring-brand-100' }}"
                            placeholder="Qty">
                        @error('quantity.0')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- Spacer: first row has no remove button --}}
                    <div class="col-span-1 h-[46px]"></div>

                </div>{{-- .order-row --}}

                {{-- ══ Re-populate old() rows after validation failure ══ --}}
                @foreach(old('product_id', []) as $i => $oldProductId)
                    @if($i === 0) @continue @endif
                    <div class="order-row grid grid-cols-12 gap-3 items-start">

                        <div class="col-span-1 flex items-center h-[46px]">
                            <span class="row-number text-xs font-bold text-slate-400 bg-slate-100
                                         w-7 h-7 rounded-lg flex items-center justify-center">
                                {{ $i + 1 }}
                            </span>
                        </div>

                        <div class="col-span-7">
                            <div class="relative">
                                <select
                                    name="product_id[]"
                                    class="w-full appearance-none px-3 py-2.5 pr-8 rounded-xl border text-sm
                                           text-slate-700 outline-none transition-all duration-200
                                           {{ $errors->has('product_id.'.$i)
                                                ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-200'
                                                : 'border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-400 focus:ring-2 focus:ring-brand-100' }}">
                                    <option value="">— Select Product —</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ $oldProductId == $product->id ? 'selected' : '' }}>
                                            {{ $product->brand->name }} — {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            @error('product_id.'.$i)
                            <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="col-span-3">
                            <input
                                type="number"
                                name="quantity[]"
                                value="{{ old('quantity.'.$i) }}"
                                min="1"
                                class="w-full px-3 py-2.5 rounded-xl border text-sm text-slate-700
                                       outline-none transition-all duration-200
                                       {{ $errors->has('quantity.'.$i)
                                            ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-200'
                                            : 'border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-400 focus:ring-2 focus:ring-brand-100' }}"
                                placeholder="Qty">
                            @error('quantity.'.$i)
                            <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="col-span-1 flex items-center h-[46px]">
                            <button type="button"
                                    class="remove-row w-8 h-8 flex items-center justify-center
                                           text-slate-400 hover:text-red-500 hover:bg-red-50
                                           rounded-lg transition-all duration-150">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                    </div>
                @endforeach

            </div>{{-- #order-container --}}

            {{-- ── Hidden product options JSON for jQuery use ── --}}
            <script id="product-options-data" type="application/json">
                [
                    @foreach($products as $product)
                    { "id": {{ $product->id }}, "label": "{{ addslashes($product->brand->name . ' — ' . $product->name) }}" }{{ !$loop->last ? ',' : '' }}
                    @endforeach
                ]
            </script>

            {{-- ── Add Row Button ── --}}
            <button
                type="button"
                id="add-row"
                class="w-full flex items-center justify-center gap-2 border-2 border-dashed
                       border-slate-200 hover:border-brand-400 hover:bg-brand-50
                       text-slate-500 hover:text-brand-600 text-sm font-semibold
                       py-2.5 rounded-xl transition-all duration-200 mt-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Add Another Product
            </button>

            {{-- ── Row Counter ── --}}
            <div class="flex justify-end">
                <span id="row-count" class="text-xs text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full font-medium">
                    1 row
                </span>
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
                    Submit Order
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

{{-- ══════════════════════════════════════════════════════════════════════
     jQuery — book-container append pattern
     product_id[] + quantity[] — two arrays, one per column
     #add-row      → append new row
     .remove-row   → remove closest .order-row
     updateCounter → update row count badge + renumber row labels
══════════════════════════════════════════════════════════════════════ --}}
<script>
$(document).ready(function () {

    /*
    |------------------------------------------------------------------
    | Product options — built from inline JSON (no extra AJAX needed)
    |------------------------------------------------------------------
    */
    var products = JSON.parse(document.getElementById('product-options-data').textContent);

    /*
    |------------------------------------------------------------------
    | buildProductOptions — build <option> tags from products array
    |------------------------------------------------------------------
    */
    function buildProductOptions(selectedId) {
        var options = '<option value="">— Select Product —</option>';
        products.forEach(function (p) {
            var selected = (selectedId && selectedId == p.id) ? 'selected' : '';
            options += '<option value="' + p.id + '" ' + selected + '>' + p.label + '</option>';
        });
        return options;
    }

    /*
    |------------------------------------------------------------------
    | updateCounter — update badge + renumber row labels
    |------------------------------------------------------------------
    */
    function updateCounter() {
        var count = $('#order-container .order-row').length;
        $('#row-count').text(count + (count === 1 ? ' row' : ' rows'));

        // renumber all row badges
        $('#order-container .order-row').each(function (index) {
            $(this).find('.row-number').text(index + 1);
        });
    }

    // sync on page load (handles old() repopulated rows)
    updateCounter();

    /*
    |------------------------------------------------------------------
    | #add-row click — append new product + quantity row
    | mirrors: $(".add-more").click → $("#book-container").append(html)
    |------------------------------------------------------------------
    */
    $('#add-row').on('click', function () {

        var html = `
        <div class="order-row grid grid-cols-12 gap-3 items-start">

            <div class="col-span-1 flex items-center h-[46px]">
                <span class="row-number text-xs font-bold text-slate-400 bg-slate-100
                             w-7 h-7 rounded-lg flex items-center justify-center">
                    0
                </span>
            </div>

            <div class="col-span-7">
                <div class="relative">
                    <select name="product_id[]"
                            class="w-full appearance-none px-3 py-2.5 pr-8 rounded-xl border
                                   border-slate-200 bg-slate-50 text-sm text-slate-700 outline-none
                                   focus:bg-white focus:border-brand-400 focus:ring-2 focus:ring-brand-100
                                   transition-all duration-200">
                        ${buildProductOptions()}
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="col-span-3">
                <input type="number" name="quantity[]" min="1"
                       class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50
                              text-sm text-slate-700 outline-none
                              focus:bg-white focus:border-brand-400 focus:ring-2 focus:ring-brand-100
                              transition-all duration-200"
                       placeholder="Qty">
            </div>

            <div class="col-span-1 flex items-center h-[46px]">
                <button type="button"
                        class="remove-row w-8 h-8 flex items-center justify-center
                               text-slate-400 hover:text-red-500 hover:bg-red-50
                               rounded-lg transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>`;

        $('#order-container').append(html);
        updateCounter();
    });

    /*
    |------------------------------------------------------------------
    | .remove-row click — remove closest .order-row
    | mirrors: $(document).on("click", ".remove", ...) pattern
    |------------------------------------------------------------------
    */
    $(document).on('click', '.remove-row', function () {
        $(this).closest('.order-row').remove();
        updateCounter();
    });

});
</script>
