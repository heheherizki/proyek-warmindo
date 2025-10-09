<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Menu Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    
                    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div>
                                    <label for="name" class="block font-medium text-sm text-gray-700">Nama Menu</label>
                                    <input id="name" name="name" type="text" value="{{ old('name') }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required autofocus>
                                    @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="mt-4">
                                    <label for="description" class="block font-medium text-sm text-gray-700">Deskripsi</label>
                                    <textarea id="description" name="description" rows="4" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('description') }}</textarea>
                                    @error('description') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="mt-4">
                                    <label for="price" class="block font-medium text-sm text-gray-700">Harga</label>
                                    <input id="price" name="price" type="number" value="{{ old('price') }}" placeholder="Contoh: 12000" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('price') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    <p class="mt-1 text-sm text-gray-500">Isi hanya dengan angka, tanpa "Rp" atau titik.</p>
                                </div>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Gambar Menu</label>
                                <div x-data="{ imageUrl: '' }" class="mt-1">
                                    <template x-if="imageUrl">
                                        <div class="mb-2">
                                            <img :src="imageUrl" class="w-full h-48 object-cover rounded-md border border-gray-300">
                                        </div>
                                    </template>
                                    
                                    <div class="flex items-center justify-center w-full">
                                        <label for="image_url" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/></svg>
                                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau seret gambar</p>
                                                <p class="text-xs text-gray-500">PNG, JPG, GIF (MAX. 2MB)</p>
                                            </div>
                                            <input id="image_url" name="image_url" type="file" class="hidden" @change="imageUrl = URL.createObjectURL($event.target.files[0])" accept="image/*" required>
                                        </label>
                                    </div>
                                    @error('image_url') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror 
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-6 border-t border-gray-200">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-600">
                                Simpan Menu
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>