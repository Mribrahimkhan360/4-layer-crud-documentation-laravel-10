<x-app-layout>

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
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Order <span class="font-mono text-indigo-600">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </h1>
                    <p class="text-gray-500 mt-1">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
                </div>

                {{-- Status Badge --}}
                @php
                    $statusClasses = [
                        'pending'   => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
                        'confirmed' => 'bg-green-100 text-green-700 border border-green-200',
                        'cancelled' => 'bg-red-100 text-red-700 border border-red-200',
                    ];
                    $badgeClass = $statusClasses[$order->order_status] ?? 'bg-gray-100 text-gray-600';
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold capitalize {{ $badgeClass }}">
                    {{ $order->order_status }}
                </span>
            </div>
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

        <div class="space-y-5">

            {{-- Order Info Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Order Info</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-400 mb-1">Placed By</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $order->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-400 mb-1">Summary</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $order->total_products }} Product(s)</p>
                        <p class="text-xs text-gray-500">{{ $order->total_quantity }} Total Qty</p>
                    </div>
                </div>
            </div>

            {{-- Products Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-700">
                        Products
                        <span class="ml-1.5 text-xs font-medium text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">
                            {{ $order->orderDetails->count() }}
                        </span>
                    </h2>
                </div>

                @if($order->orderDetails->isEmpty())
                    <div class="text-center py-10 text-gray-400 text-sm">
                        No products found in this order.
                    </div>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-gray-400 uppercase text-xs tracking-wider">
                                <th class="text-left px-6 py-3">#</th>
                                <th class="text-left px-6 py-3">Product Name</th>
                                <th class="text-right px-6 py-3">Quantity</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($order->orderDetails as $index => $detail)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-3.5 text-gray-400 font-medium">{{ $index + 1 }}</td>
                                    <td class="px-6 py-3.5">
                                        <span class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-indigo-400 flex-shrink-0"></span>
                                            <span class="text-gray-800 font-medium">{{ $detail->product_name }}</span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5 text-right">
                                        <span class="inline-flex items-center gap-1 bg-indigo-50 text-indigo-700
                                                     text-xs font-semibold px-2.5 py-1 rounded-full">
                                            × {{ $detail->product_quantity }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-50 border-t border-gray-200">
                                <td colspan="2" class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Total Quantity
                                </td>
                                <td class="px-6 py-3 text-right text-sm font-bold text-gray-800">
                                    {{ $order->total_quantity }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                @endif
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-between">
                <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this order?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold
                                   text-red-600 bg-red-50 hover:bg-red-100 border border-red-100 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete Order
                    </button>
                </form>

                <a href="{{ route('orders.edit', $order->id) }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold
                          text-white bg-indigo-600 hover:bg-indigo-700 shadow transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Order
                </a>
            </div>

        </div>
    </div>
</div>
</x-app-layout>

