<x-app-layout>
    {{-- Main Content --}}
    <div class="flex-1">
        <nav class="bg-gray-100 border-b">
            <div class="container mx-auto px-4 py-3 flex items-center">
                <h5 class="text-lg font-medium">Edit Permission</h5>
            </div>
        </nav>

        <div class="container mx-auto my-10 px-4">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="bg-blue-600 text-white px-6 py-4">
                    <h4 class="text-xl font-semibold">Edit Permission</h4>
                </div>

                <div class="p-6">

                    @if(session('success'))
                        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4 flex justify-between items-center">
                            <span>{{ session('success') }}</span>
                            <button type="button" class="text-green-800 font-bold" onclick="this.parentElement.remove()">&times;</button>
                        </div>
                    @endif

                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-2 flex justify-between items-center">
                                <span>{{ $error }}</span>
                                <button type="button" class="text-red-800 font-bold" onclick="this.parentElement.remove()">&times;</button>
                            </div>
                        @endforeach
                    @endif

                    <form action="{{ route('permissions.update', $permission->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Permission Name</label>
                                <input type="text" name="name"
                                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       value="{{ old('name', $permission->name) }}"/>
                                <small class="text-gray-500 text-xs">Use lowercase with hyphens.</small>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Guard Name</label>
                                <select name="guard_name"
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="web" {{ old('guard_name', $permission->guard_name) == 'web' ? 'selected' : '' }}>web</option>
                                    <option value="api" {{ old('guard_name', $permission->guard_name) == 'api' ? 'selected' : '' }}>api</option>
                                </select>
                            </div>

                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('permissions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update Permission</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
