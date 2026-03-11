<x-app-layout>

    {{-- Main Content --}}
    <div class="flex-1">
        <!-- Navbar -->
        <nav class="bg-gray-100 border-b border-gray-200">
            <div class="container mx-auto px-4 py-3 flex items-center">
                <h5 class="text-lg font-medium">Create Permission</h5>
            </div>
        </nav>

        <!-- Container -->
        <div class="container mx-auto my-12 px-4">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Card Header -->
                <div class="bg-blue-600 text-white px-6 py-4">
                    <h4 class="text-xl font-semibold">Add New Permission</h4>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="absolute top-2 right-2 text-green-700 hover:text-green-900" onclick="this.parentElement.remove();">
                                &times;
                            </button>
                        </div>
                    @endif

                <!-- Error Messages -->
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                                {{ $error }}
                            </div>
                    @endforeach
                @endif

                <!-- Form -->
                    <form action="{{ route('permissions.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Permission Name -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Permission Name</label>
                                <input type="text" name="name"
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       value="{{ old('name') }}"
                                       placeholder="e.g. create-user, edit-post">
                                <p class="text-gray-500 text-sm mt-1">Use lowercase with hyphens.</p>
                            </div>

                            <!-- Guard Name -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Guard Name</label>
                                <select name="guard_name"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="web" {{ old('guard_name', 'web') == 'web' ? 'selected' : '' }}>web</option>
                                    <option value="api" {{ old('guard_name') == 'api' ? 'selected' : '' }}>api</option>
                                </select>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('permissions.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">Cancel</a>
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Add Permission</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
