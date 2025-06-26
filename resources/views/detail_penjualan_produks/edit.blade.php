<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Detail Penjualan Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('detail_penjualan_produk.update', $detailPenjualanProduk->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="id_penjualan" :value="__('ID Penjualan')" />
                            <select id="id_penjualan" name="id_penjualan" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Penjualan</option>
                                @foreach($penjualans as $penjualan)
                                    <option value="{{ $penjualan->id }}" {{ old('id_penjualan', $detailPenjualanProduk->id_penjualan) == $penjualan->id ? 'selected' : '' }}>
                                        #{{ $penjualan->id }} - {{ $penjualan->tanggal_penjualan->format('d M Y') }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_penjualan')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="id_produk" :value="__('Produk')" />
                            <select id="id_produk" name="id_produk" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Produk</option>
                                @foreach($produks as $produk)
                                    <option value="{{ $produk->id }}" {{ old('id_produk', $detailPenjualanProduk->id_produk) == $produk->id ? 'selected' : '' }}>
                                        {{ $produk->nama_produk }} (Stok: {{ $produk->stok }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_produk')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="jumlah_terjual" :value="__('Jumlah Terjual')" />
                            <x-text-input id="jumlah_terjual" class="block mt-1 w-full" type="number" name="jumlah_terjual" :value="old('jumlah_terjual', $detailPenjualanProduk->jumlah_terjual)" required min="1" />
                            <x-input-error :messages="$errors->get('jumlah_terjual')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="harga_jual" :value="__('Harga Jual')" />
                            <x-text-input id="harga_jual" class="block mt-1 w-full" type="number" step="0.01" name="harga_jual" :value="old('harga_jual', $detailPenjualanProduk->harga_jual)" required />
                            <x-input-error :messages="$errors->get('harga_jual')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="harga_beli" :value="__('Harga Beli')" />
                            <x-text-input id="harga_beli" class="block mt-1 w-full" type="number" step="0.01" name="harga_beli" :value="old('harga_beli', $detailPenjualanProduk->harga_beli)" required />
                            <x-input-error :messages="$errors->get('harga_beli')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="subtotal_pendapatan" :value="__('Subtotal Pendapatan')" />
                            <x-text-input id="subtotal_pendapatan" class="block mt-1 w-full" type="number" step="0.01" name="subtotal_pendapatan" :value="old('subtotal_pendapatan', $detailPenjualanProduk->subtotal_pendapatan)" required />
                            <x-input-error :messages="$errors->get('subtotal_pendapatan')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="subtotal_keuntungan" :value="__('Subtotal Keuntungan')" />
                            <x-text-input id="subtotal_keuntungan" class="block mt-1 w-full" type="number" step="0.01" name="subtotal_keuntungan" :value="old('subtotal_keuntungan', $detailPenjualanProduk->subtotal_keuntungan)" required />
                            <x-input-error :messages="$errors->get('subtotal_keuntungan')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('detail_penjualan_produk.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Perbarui Detail Penjualan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>