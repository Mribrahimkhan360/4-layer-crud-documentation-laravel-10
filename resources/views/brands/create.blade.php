<x-app-layout>

    <x-slot name="title">
        Add Brand
    </x-slot>

    <x-slot name="subtitle">
        Create a new brand entry
    </x-slot>

    <x-slot name="header-action">
        <a href="{{ route('brands.index') }}"
           class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-md shadow-brand-600/30 transition-all duration-200 hover:scale-105">
            Back to Brands
        </a>
    </x-slot>

    {{-- Page Content --}}
    <div>
        <div class="max-w-lg">

            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

                {{-- Card Header --}}
                <div class="px-7 py-5 border-b border-slate-100 bg-gradient-to-r from-brand-50 to-white">
                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-xl bg-brand-600 flex items-center justify-center shadow-md shadow-brand-600/30">
                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>

                        <div>
                            <p class="font-bold text-slate-800 text-sm">New Brand</p>
                            <p class="text-xs text-slate-500">Fill in the brand information below</p>
                        </div>

                    </div>
                </div>

                {{-- Form --}}
                <form action="{{ route('brands.store') }}" method="POST" class="px-7 py-6 space-y-5">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                            Brand Name
                            <span class="text-red-500 normal-case tracking-normal">*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="e.g. Apple, Samsung, Sony"
                            autofocus
                            class="w-full px-4 py-3 rounded-xl border text-sm text-slate-700 placeholder-slate-400 outline-none transition-all duration-200
                            {{ $errors->has('name') ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-200' : 'border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-400 focus:ring-2 focus:ring-brand-100' }}"
                        >

                        @error('name')
                        <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                      clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3 pt-2">

                        <button type="submit"
                                class="flex-1 inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-gray-700 font-semibold text-sm py-3 rounded-xl shadow-md shadow-brand-600/30 transition-all duration-200 hover:scale-[1.02]">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Save Brand
                        </button>

                        <a href="{{ route('brands.index') }}"
                           class="px-5 py-3 text-sm font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors duration-200">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>
