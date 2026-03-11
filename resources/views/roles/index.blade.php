<x-app-layout>
    {{-- Main Content --}}
    <div class="flex-1">
        <!-- Navbar -->
        <nav class="bg-gray-100 border-b border-gray-300">
            <div class="container mx-auto flex items-center justify-between py-3 px-4">
                <h5 class="text-lg font-semibold">Role List</h5>
                <a href="{{ route('roles.create') }}"
                   class="bg-blue-600 text-white text-sm px-3 py-1 rounded hover:bg-blue-700 transition">
                    + Add Role
                </a>
            </div>
        </nav>

        <div class="container mx-auto my-6 px-4">

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3"
                            onclick="this.parentElement.style.display='none';">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 00-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/></svg>
                    </button>
                </div>
        @endif

        <!-- Card -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium uppercase">#</th>
                            <th class="px-6 py-3 text-left text-sm font-medium uppercase">Role Name</th>
                            <th class="px-6 py-3 text-left text-sm font-medium uppercase">Permissions</th>
                            <th class="px-6 py-3 text-left text-sm font-medium uppercase">Action</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($roles as $key => $role)
                            <tr>
                                <td class="px-6 py-3 whitespace-nowrap">{{ $key + 1 }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">{{ $role->name }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">
                                    @forelse($role->permissions as $permission)
                                        <span class="inline-block bg-blue-200 text-blue-800 text-xs px-2 py-1 rounded mr-1 mb-1">
                                            {{ $permission->name }}
                                        </span>
                                    @empty
                                        <span class="text-gray-500 text-sm">No permissions</span>
                                    @endforelse
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap">
                                    <a href="{{ route('roles.edit', $role->id) }}"
                                       class="bg-yellow-400 text-white px-2 py-1 rounded text-xs hover:bg-yellow-500 transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600 transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No roles found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
