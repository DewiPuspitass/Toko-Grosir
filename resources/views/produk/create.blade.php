<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Produk Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="nama_produk" :value="__('Nama Produk')" />
                            <x-text-input id="nama_produk" class="block mt-1 w-full" type="text" name="nama_produk" :value="old('nama_produk')" required autofocus />
                            <x-input-error :messages="$errors->get('nama_produk')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('deskripsi') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="harga_beli" :value="__('Harga Beli')" />
                            <x-text-input id="harga_beli" class="block mt-1 w-full" type="number" step="0.01" name="harga_beli" :value="old('harga_beli')" required />
                            <x-input-error :messages="$errors->get('harga_beli')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="harga_jual" :value="__('Harga Jual')" />
                            <x-text-input id="harga_jual" class="block mt-1 w-full" type="number" step="0.01" name="harga_jual" :value="old('harga_jual')" required />
                            <x-input-error :messages="$errors->get('harga_jual')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="stok" :value="__('Stok')" />
                            <x-text-input id="stok" class="block mt-1 w-full" type="number" name="stok" :value="old('stok')" required />
                            <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="gambar_produk" :value="__('Gambar Produk')" />
                            <input id="gambar_produk" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="gambar_produk" accept="image/*">
                            <p class="mt-1 text-sm text-gray-500" id="file_input_help">JPEG, PNG atau JPG (MAX. 2MB).</p>
                            <x-input-error :messages="$errors->get('gambar_produk')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="kategori_id" :value="__('Kategori')" />
                            <select id="kategori_id" name="kategori_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('kategori_id')" class="mt-2" />
                        </div>

                        <div class="mb-4 flex items-center">
                            <input type="checkbox" id="aktif" name="aktif" value="1" {{ old('aktif') ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <x-input-label for="aktif" :value="__('Produk Aktif')" class="ml-2" />
                            <x-input-error :messages="$errors->get('aktif')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('produk.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Produk') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>