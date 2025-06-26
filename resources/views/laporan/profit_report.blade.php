<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Keuntungan') }} ({{ ucfirst($period) }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">Periode: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>

                    @if ($reportData->isEmpty())
                        <p class="text-gray-500">Tidak ada data keuntungan untuk periode dan jenis laporan ini.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @if ($period == 'daily')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        @elseif ($period == 'weekly')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Minggu ke-</th>
                                        @elseif ($period == 'monthly')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bulan ke-</th>
                                        @endif
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pendapatan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Keuntungan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($reportData as $data)
                                        <tr>
                                            @if ($period == 'daily')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ Carbon::parse($data->periode_label)->format('d M Y') }}</td>
                                            @elseif ($period == 'weekly' || $period == 'monthly')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $data->tahun }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $data->periode_label }}</td>
                                            @endif
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($data->total_pendapatan, 2, ',', '.') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($data->total_keuntungan, 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('laporan.index', request()->all()) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                            {{ __('Kembali ke Laporan Utama') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>