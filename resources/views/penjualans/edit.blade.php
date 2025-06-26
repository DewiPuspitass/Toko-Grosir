<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('penjualan.update', $penjualan->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="tanggal_penjualan" :value="__('Tanggal Penjualan')" />
                            <x-text-input id="tanggal_penjualan" class="block mt-1 w-full" type="date" name="tanggal_penjualan" :value="old('tanggal_penjualan', $penjualan->tanggal_penjualan->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('tanggal_penjualan')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="total_pendapatan" :value="__('Total Pendapatan')" />
                            <x-text-input id="total_pendapatan" class="block mt-1 w-full" type="number" step="0.01" name="total_pendapatan" :value="old('total_pendapatan', $penjualan->total_pendapatan)" required />
                            <x-input-error :messages="$errors->get('total_pendapatan')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="total_keuntungan" :value="__('Total Keuntungan')" />
                            <x-text-input id="total_keuntungan" class="block mt-1 w-full" type="number" step="0.01" name="total_keuntungan" :value="old('total_keuntungan', $penjualan->total_keuntungan)" required />
                            <x-input-error :messages="$errors->get('total_keuntungan')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('penjualan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Perbarui Penjualan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>