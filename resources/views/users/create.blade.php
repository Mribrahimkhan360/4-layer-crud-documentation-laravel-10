<x-app-layout>
    {{-- Main Content --}}
    <div class="flex-1">
        <!-- Navbar -->
        <nav class="bg-gray-100 border-b border-gray-300">
            <div class="container mx-auto px-4 py-3 flex items-center">
                <h5 class="text-lg font-semibold">Create User</h5>
            </div>
        </nav>

        <!-- Form Container -->
        <div class="container mx-auto my-12 px-4">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Card Header -->
                <div class="bg-blue-600 text-white px-6 py-4">
                    <h4 class="text-xl font-semibold">Add New User</h4>
                </div>

                <!-- Card Body -->
                <div class="px-6 py-6">

                    <!-- Success Alert -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                            <button type="button" class="absolute top-2 right-2 text-green-700 hover:text-green-900" onclick="this.parentElement.style.display='none'">
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
                    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- User Name -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">User Name</label>
                                <input type="text" name="name" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       value="{{ old('name') }}" placeholder="Enter user name"/>
                            </div>

                            <!-- User Email -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">User Email</label>
                                <input type="email" name="email" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       value="{{ old('email') }}" placeholder="Enter email"/>
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Role</label>
                                <select name="role" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">-- Select Role --</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Password</label>
                                <input type="password" name="password" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="Enter password"/>
                            </div>

                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3">
                            <button type="reset" class="bg-gray-500 hover:bg-gray-600 text-white font-medium px-4 py-2 rounded">Reset</button>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded">Add User</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
