<x-app-layout>
    <div class="mb-4 flex justify-end">
        <a href="{{ route('users.create') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm transition">
            Create User
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            <thead class="bg-gray-800 text-white">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium">#</th>
                <th class="px-4 py-2 text-left text-sm font-medium">Name</th>
                <th class="px-4 py-2 text-left text-sm font-medium">Email</th>
                <th class="px-4 py-2 text-left text-sm font-medium">Role</th>
                <th class="px-4 py-2 text-left text-sm font-medium">Action</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @forelse($users as $key => $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-2 text-sm">{{ $key + 1 }}</td>
                    <td class="px-4 py-2 text-sm">{{ $user->name }}</td>
                    <td class="px-4 py-2 text-sm">{{ $user->email }}</td>
                    <td class="px-4 py-2 text-sm">
                        @foreach($user->roles as $role)
                            <span
                                class="inline-block bg-green-500 text-white text-xs px-2 py-1 rounded-full mr-1">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td class="px-4 py-2 text-sm flex gap-2">
                        <a href="{{ route('users.edit', $user->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition">Edit</a>

                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">No users found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
