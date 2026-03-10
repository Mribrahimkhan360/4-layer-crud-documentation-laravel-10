<x-app-layout>
    {{-- Main Content --}}
    <div class="flex-grow">
        <!-- Navbar -->
        <nav class="bg-gray-100 border-b">
            <div class="container mx-auto px-4 py-3 flex items-center">
                <h5 class="text-lg font-medium">Edit Role</h5>
            </div>
        </nav>

        <!-- Main Container -->
        <div class="container mx-auto my-10 px-4">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Card Header -->
                <div class="bg-blue-600 text-white px-6 py-4">
                    <h4 class="text-xl font-semibold">Edit Role</h4>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative" role="alert">
                            {{ session('success') }}
                            <button type="button" class="absolute top-2 right-2 text-green-700 hover:text-green-900" onclick="this.parentElement.remove();">&times;</button>
                        </div>
                    @endif

                <!-- Error Messages -->
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative">
                                {{ $error }}
                                <button type="button" class="absolute top-2 right-2 text-red-700 hover:text-red-900" onclick="this.parentElement.remove();">&times;</button>
                            </div>
                    @endforeach
                @endif

                <!-- Form -->
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Role Name -->
                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2">Role Name</label>
                                <input type="text" name="name"
                                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       value="{{ old('name', $role->name) }}" />
                            </div>

                            <!-- Permissions -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-medium mb-2">Permissions</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach($permissions as $permission)
                                        <div class="flex items-center">
                                            <input
                                                type="checkbox"
                                                name="permissions[]"
                                                value="{{ $permission->name }}"
                                                id="perm_{{ $permission->id }}"
                                                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                            />
                                            <label for="perm_{{ $permission->id }}" class="ml-2 text-gray-700">{{ $permission->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('roles.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</a>
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Update Role</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
