<?php

namespace App\Exports;

use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProfitReportExport implements FromCollection, WithHeadings
{
    protected $startDate, $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Penjualan::select(
                DB::raw('DATE(tanggal_penjualan) as tanggal'),
                DB::raw('SUM(total_pendapatan) as total_pendapatan'),
                DB::raw('SUM(total_keuntungan) as total_keuntungan')
            )
            ->whereBetween('tanggal_penjualan', [$this->startDate, $this->endDate])
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Total Pendapatan',
            'Total Keuntungan',
        ];
    }
}

