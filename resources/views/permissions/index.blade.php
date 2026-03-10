<x-app-layout>
    {{-- Main Content --}}
    <div class="flex-grow">
        <!-- Navbar -->
        <nav class="bg-gray-100 border-b border-gray-300 py-3">
            <div class="container mx-auto flex items-center justify-between px-4">
                <h5 class="text-lg font-semibold">Permission List</h5>
                <a href="{{ route('permissions.create') }}"
                   class="bg-blue-600 text-white text-sm px-3 py-1 rounded hover:bg-blue-700 transition">+ Add Permission</a>
            </div>
        </nav>

        <!-- Container -->
        <div class="container mx-auto my-4 px-4">

            <!-- Success Alert -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative mb-4"
                     role="alert">
                    {{ session('success') }}
                    <button type="button" onclick="this.parentElement.remove()"
                            class="absolute top-0 right-0 mt-1 mr-2 text-green-700 font-bold">&times;</button>
                </div>
        @endif

        <!-- Card -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="p-4">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2 border-r border-gray-700 text-left">#</th>
                            <th class="px-4 py-2 border-r border-gray-700 text-left">Permission Name</th>
                            <th class="px-4 py-2 border-r border-gray-700 text-left">Guard</th>
                            <th class="px-4 py-2 border-r border-gray-700 text-left">Created At</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($permissions as $key => $permission)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border-t border-gray-200">{{ $key + 1 }}</td>
                                <td class="px-4 py-2 border-t border-gray-200">
                                    <span class="bg-yellow-300 text-yellow-900 px-2 py-1 rounded">{{ $permission->name }}</span>
                                </td>
                                <td class="px-4 py-2 border-t border-gray-200">
                                    <span class="bg-gray-400 text-gray-900 px-2 py-1 rounded">{{ $permission->guard_name }}</span>
                                </td>
                                <td class="px-4 py-2 border-t border-gray-200">{{ $permission->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-2 border-t border-gray-200 space-x-2">
                                    <a href="{{ route('permissions.edit', $permission->id) }}"
                                       class="bg-yellow-500 text-white text-sm px-2 py-1 rounded hover:bg-yellow-600 transition">Edit</a>

                                    <form action="{{ route('permissions.destroy', $permission->id) }}"
                                          method="POST" class="inline-block"
                                          onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 text-white text-sm px-2 py-1 rounded hover:bg-red-600 transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">No permissions found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>


