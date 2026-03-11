{{-- resources/views/stocks/index.blade.php --}}
<x-app-layout>
<div class="max-w-5xl">

    {{-- ── Flash Messages ── --}}
    @if(session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700
                text-sm rounded-xl flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── Card ── --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

        {{-- Header --}}
        <div class="px-7 py-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <p class="font-bold text-gray-700 text-sm">Stock Entries</p>
                <p class="text-xs text-slate-500">{{ $stocks->count() }} total records</p>
            </div>
            <a href="{{ route('stocks.create') }}"
               class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700
                      text-gray-500 text-sm font-semibold px-4 py-2.5 rounded-xl
                      shadow-md shadow-brand-600/30 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Add Stock
            </a>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-slate-700">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">#</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Product</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Serial Number</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($stocks as $stock)
                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                        <td class="px-6 py-3 text-slate-400">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3 font-medium">{{ $stock->product->name ?? 'N/A' }}</td>

                        <td class="px-6 py-3 font-mono">{{ $stock->serial_number }}</td>
                        <td class="px-6 py-3 text-slate-400">{{ $stock->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-2">
                                {{-- Edit --}}
                                <a href="{{ route('stocks.edit', $stock->id) }}"
                                   class="text-xs font-semibold text-brand-600 hover:text-brand-700
                                          bg-brand-50 hover:bg-brand-100 px-3 py-1.5 rounded-lg transition-colors">
                                    Edit
                                </a>
                                {{-- Delete --}}
                                <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST"
                                      onsubmit="return confirm('Delete this stock entry?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-xs font-semibold text-red-500 hover:text-red-700
                                                   bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400 text-sm">
                            No stock entries found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
</x-app-layout>
