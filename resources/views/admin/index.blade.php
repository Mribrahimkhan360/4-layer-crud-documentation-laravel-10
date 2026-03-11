<x-app-layout>

    <div class="min-h-screen bg-gray-50 py-8 px-4">
        <div class="w-full mx-auto">

            <!-- Admin -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full">

                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-gray-700">
                        Admin
                    </h2>

{{--                    <a href=""--}}
{{--                       class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">--}}
{{--                        Place an Order--}}
{{--                    </a>--}}
                </div>

                <!-- Table -->
                <table class="w-full text-sm">
                    <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-400 uppercase text-xs tracking-wider">
                        <th class="text-left px-6 py-3">#</th>
                        <th class="text-left px-6 py-3">Product Name</th>
                        <th class="text-left px-6 py-3">Order Id</th>
                        <th class="text-left px-6 py-3">Order BUY</th>
                        <th class="text-right px-6 py-3">Quantity</th>
                        <th class="text-right px-6 py-3">Action</th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-50">
                    @foreach($orders as $index => $order)
                        <tr class="hover:bg-gray-50">
                            <!-- Index -->
                            <td class="px-6 py-3 text-sm text-gray-700 font-medium">{{ $index + 1 }}</td>

                            <!-- Product Names -->
                            <td class="px-6 py-3 text-sm text-gray-700">
                                {{ $order->orderDetails->pluck('product_name')->join(', ') }}
                            </td>

                            <!-- Order IDs (usually all same for the order, so take first) -->
                            <td class="px-6 py-3 text-sm text-gray-700">
                                {{ optional($order->orderDetails->first())->order_id ?? 'N/A' }}
                            </td>

                            <!-- Customer / Status -->
                            <td class="px-6 py-3 text-sm text-gray-700">Unknown</td>

                            <!-- Product Quantities -->
                            <td class="px-6 py-3 text-sm text-gray-700 text-right">
                                {{ $order->orderDetails->pluck('product_quantity')->join(', ') }}
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-3 text-sm text-gray-700 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- View -->
                                    <a href="#"
                                       class="p-2 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition"
                                       title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach                    </tbody>

{{--                    {{ dd($orders->toArray()) }}--}}
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
