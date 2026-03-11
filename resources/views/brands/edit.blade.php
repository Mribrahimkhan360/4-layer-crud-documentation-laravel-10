<x-app-layout>
<div class="container mx-auto px-4 sm:px-0" style="max-width: 500px;">

    <h2 class="mb-6 text-2xl font-semibold text-slate-800">Edit Brand</h2>

    <form action="{{ route('brands.update', $brand->id) }}" method="POST" class="bg-white p-6 rounded-xl shadow-md border border-slate-200">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="form-label block text-sm font-medium text-slate-700 mb-1">
                Brand Name <span class="text-red-500">*</span>
            </label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $brand->name) }}"
                   class="form-control block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-brand-500 focus:border-brand-500 @error('name') is-invalid @enderror">
            @error('name')
            <div class="invalid-feedback mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex flex-wrap gap-3 mt-4">
            <button type="submit" class="btn btn-primary flex-1">
                Update Brand
            </button>
            <a href="{{ route('brands.index') }}" class="btn btn-secondary flex-1 text-center">
                Cancel
            </a>
        </div>
    </form>

</div>
</x-app-layout>
