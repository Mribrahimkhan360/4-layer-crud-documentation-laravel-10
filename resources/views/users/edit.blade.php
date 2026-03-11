<x-app-layout>

    {{-- Main Content --}}
    <div class="flex-grow">
        <!-- Navbar -->
        <nav class="bg-gray-100 border-b">
            <div class="container mx-auto px-4 py-3 flex items-center">
                <h5 class="text-lg font-medium">Edit User</h5>
            </div>
        </nav>

        <!-- Main Container -->
        <div class="container mx-auto my-10 px-4">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Card Header -->
                <div class="bg-blue-600 text-white px-6 py-4">
                    <h4 class="text-lg font-semibold">Edit User</h4>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    <!-- Success Alert -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                                &times;
                            </button>
                        </div>
                    @endif

                <!-- Error Alerts -->
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-3">
                                {{ $error }}
                            </div>
                    @endforeach
                @endif

                <!-- Form -->
                    <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">User Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">User Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Role</label>
                                <select name="role" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">-- Select Role --</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">
                                    New Password
                                    <small class="text-gray-500">(leave blank to keep current)</small>
                                </label>
                                <input type="password" name="password" placeholder="Enter new password"
                                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</a>
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Update User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

