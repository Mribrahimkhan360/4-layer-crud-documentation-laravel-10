<?php

use App\Services\StockService;
use Livewire\Component;

new class extends Component
{
    public string $product_id    = '';
    public array  $serial_numbers = [''];
    public $products              = [];

    /*
    |--------------------------------------------------------------------------
    | Mount — load products once when component boots
    | render() must NOT exist in Volt inline components — blade is inline
    |--------------------------------------------------------------------------
    */

    public function mount(StockService $stockService): void
    {
        $this->products = $stockService->getAllProductsWithBrand();
    }

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    protected function rules(): array
    {
        $rules = [
            'product_id' => 'required|exists:products,id',
        ];

        foreach ($this->serial_numbers as $i => $sn) {
            $rules["serial_numbers.$i"] = 'required|string|unique:stocks,serial_number';
        }

        return $rules;
    }

    protected function messages(): array
    {
        $messages = [];

        foreach ($this->serial_numbers as $i => $sn) {
            $messages["serial_numbers.$i.required"] = 'Serial number is required.';
            $messages["serial_numbers.$i.unique"]   = 'This serial number already exists.';
        }

        return $messages;
    }

    /*
    |--------------------------------------------------------------------------
    | Serial Row Actions
    |--------------------------------------------------------------------------
    */

    public function addSerial(): void
    {
        $this->serial_numbers[] = '';
        $this->serial_numbers   = array_values($this->serial_numbers);
    }

    public function removeSerial(int $index): void
    {
        if (count($this->serial_numbers) > 1) {
            array_splice($this->serial_numbers, $index, 1);
            $this->serial_numbers = array_values($this->serial_numbers);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Save — delegates entirely to StockService
    |--------------------------------------------------------------------------
    */

    public function save(StockService $stockService): void
    {
        $this->validate();

        $stockService->createBulkStocks(
            productId:     (int) $this->product_id,
            serialNumbers: $this->serial_numbers,
        );

        session()->flash('success', count($this->serial_numbers) . ' stock entries saved successfully.');
        $this->redirect(route('stocks.index'), navigate: true);
    }
};
?>

<div class="max-w-xl">
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

        {{-- Card Header --}}
        <div class="px-7 py-5 border-b border-slate-100 bg-gradient-to-r from-brand-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-brand-600 flex items-center justify-center shadow-md shadow-brand-600/30">
                    <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-gray-500 text-sm">Add Stock Entries</p>
                    <p class="text-xs text-slate-500">Select a product and enter serial numbers</p>
                </div>
            </div>
        </div>

        <form wire:submit="save" class="px-7 py-6 space-y-6">

            {{-- Product Select --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                    Product <span class="text-red-500 normal-case tracking-normal">*</span>
                </label>
                <div class="relative">
                    <select
                        name="product_id"
                        wire:model.live="product_id"
                        class="w-full appearance-none px-4 py-3 pr-10 rounded-xl border text-sm text-slate-700 outline-none transition-all duration-200
                               {{ $errors->has('product_id') ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-200' : 'border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-400 focus:ring-2 focus:ring-brand-100' }}">
                        <option value="">— Select Product —</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">
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
                    <span class="text-xs text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full font-medium">
                        {{ count($serial_numbers) }} {{ count($serial_numbers) === 1 ? 'entry' : 'entries' }}
                    </span>
                </div>

                <div class="space-y-2.5">
                    @foreach($serial_numbers as $i => $serial)
                        <div class="flex items-start gap-2" wire:key="serial-row-{{ $i }}">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 bg-slate-50 border rounded-xl px-3 py-2.5 focus-within:ring-2 focus-within:bg-white transition-all duration-200
                                            {{ $errors->has('serial_numbers.'.$i) ? 'border-red-400 focus-within:ring-red-100' : 'border-slate-200 focus-within:border-brand-400 focus-within:ring-brand-100' }}">
                                    <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                    </svg>
                                    <input
                                        type="text"
                                        wire:model.lazy="serial_numbers.{{ $i }}"
                                        name="serial_number"
                                        class="flex-1 bg-transparent text-sm text-slate-700 placeholder-slate-400 outline-none font-mono tracking-wide"
                                        placeholder="e.g. SN-{{ str_pad($i + 1, 5, '0', STR_PAD_LEFT) }}"
                                        @if($i === count($serial_numbers) - 1) autofocus @endif
                                    >
                                </div>
                                @error('serial_numbers.'.$i)
                                <p class="mt-1 text-xs text-red-500 flex items-center gap-1 pl-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            @if(count($serial_numbers) > 1)
                                <button
                                    type="button"
                                    wire:click="removeSerial({{ $i }})"
                                    class="mt-0.5 w-9 h-9 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all duration-150 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            @else
                                <div class="w-9 h-9 flex-shrink-0"></div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <button
                    type="button"
                    wire:click="addSerial"
                    class="mt-3 w-full flex items-center justify-center gap-2 border-2 border-dashed border-slate-200 hover:border-brand-400 hover:bg-brand-50 text-slate-500 hover:text-brand-600 text-sm font-semibold py-2.5 rounded-xl transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Another Serial Number
                </button>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-1">
                <button
                    type="submit"
                    class="flex-1 inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-gray-600 font-semibold text-sm py-3 rounded-xl shadow-md shadow-brand-600/30 transition-all duration-200 hover:scale-[1.02]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span wire:loading.remove wire:target="save">Save Stock Entries</span>
                    <span wire:loading wire:target="save">Saving...</span>
                </button>
                <a href="{{ route('stocks.index') }}"
                   class="px-5 py-3 text-sm font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors duration-200">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>
