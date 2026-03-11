<x-app-layout>
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
                <p class="text-gray-500 mt-1">Track and manage all your orders</p>
            </div>
            <a href="{{ route('orders.create') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow transition duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Order
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Orders Table --}}
        @if($orders->isEmpty())
            <div class="text-center py-20 bg-white rounded-2xl border border-dashed border-gray-300">
                <svg class="mx-auto w-14 h-14 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13M7 13L5.4 5M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
                </svg>
                <p class="text-gray-500 font-medium text-lg">No orders yet</p>
                <p class="text-gray-400 text-sm mt-1 mb-5">Place your first order to get started.</p>
                <a href="{{ route('orders.create') }}"
                   class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">
                    Place an Order
                </a>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase text-xs tracking-wider">
                            <th class="text-left px-6 py-4">#</th>
                            <th class="text-left px-6 py-4">Order ID</th>
                            <th class="text-left px-6 py-4">Products</th>
                            <th class="text-left px-6 py-4">Total Qty</th>
                            <th class="text-left px-6 py-4">Status</th>
                            <th class="text-left px-6 py-4">Date</th>
                            <th class="text-right px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($orders as $index => $order)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">

                                {{-- Row Number --}}
                                <td class="px-6 py-4 text-gray-400 font-medium">1</td>

                                {{-- Order ID --}}
                                <td class="px-6 py-4">
                                    <span class="font-mono font-semibold text-gray-800">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>

                                {{-- Products Preview --}}
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($order->orderDetails->take(2) as $detail)
                                            <span class="bg-indigo-50 text-indigo-700 text-xs px-2 py-0.5 rounded-full font-medium">
                                                {{ $detail->product_name }}
                                            </span>
                                        @endforeach
                                        @if($order->orderDetails->count() > 2)
                                            <span class="bg-gray-100 text-gray-500 text-xs px-2 py-0.5 rounded-full">
                                                +{{ $order->orderDetails->count() - 2 }} more
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Total Quantity --}}
                                <td class="px-6 py-4 text-gray-700 font-semibold">
                                    {{ $order->total_quantity }}
                                </td>

                                {{-- Status Badge --}}
                                <td class="px-6 py-4">
                                    @php
                                        $statusClasses = [
                                            'pending'   => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
                                            'confirmed' => 'bg-green-100 text-green-700 border border-green-200',
                                            'cancelled' => 'bg-red-100 text-red-700 border border-red-200',
                                        ];
                                        $badgeClass = $statusClasses[$order->order_status] ?? 'bg-gray-100 text-gray-600';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold capitalize {{ $badgeClass }}">
                                        {{ $order->order_status }}
                                    </span>
                                </td>

                                {{-- Date --}}
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $order->created_at->format('d M Y') }}
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">

                                        {{-- View --}}
                                        <a href="{{ route('orders.show', $order->id) }}"
                                           class="p-2 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition"
                                           title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('orders.edit', $order->id) }}"
                                           class="p-2 rounded-lg text-gray-400 hover:text-amber-600 hover:bg-amber-50 transition"
                                           title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                              onsubmit="return confirm('Delete this order and all its products?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition"
                                                    title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
</div>
</x-app-layout>
