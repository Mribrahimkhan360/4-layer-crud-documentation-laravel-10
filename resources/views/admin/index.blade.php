<x-app-layout>

    <div class="min-h-screen bg-gray-50 py-8 px-4">
        <div class="w-full mx-auto">

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    Order <span class="font-mono text-indigo-600">#00001</span>
                </h1>
                <p class="text-gray-500 mt-1">Placed on 10 Mar 2026, 02:00 PM</p>
            </div>

            <!-- Order Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">
                    Order Info
                </h2>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-400 mb-1">Order Buy</p>
                        <p class="text-sm font-semibold text-gray-800">John Doe</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-400 mb-1">Total Products</p>
                        <p class="text-sm font-semibold text-gray-800">3</p>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full">

                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-700">
                        Products
                    </h2>
                </div>

                <table class="w-full text-sm">
                    <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-400 uppercase text-xs tracking-wider">
                        <th class="text-left px-6 py-3">#</th>
                        <th class="text-left px-6 py-3">Product Name</th>
                        <th class="text-right px-6 py-3">Quantity</th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-50">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">1</td>
                        <td class="px-6 py-3">Laptop</td>
                        <td class="px-6 py-3 text-right">2</td>
                    </tr>
                    </tbody>
                </table>

            </div>

        </div>
    </div>

</x-app-layout>
