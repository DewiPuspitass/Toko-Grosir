<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';

    protected $primaryKey = 'id';

    protected $fillable = [
        'tanggal_penjualan',
        'total_pendapatan',
        'total_keuntungan',
        'id_admin',
    ];

    protected $casts = [
        'tanggal_penjualan' => 'date',
        'total_pendapatan' => 'decimal:2',
        'total_keuntungan' => 'decimal:2',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_admin', 'id');
    }

    public function detailPenjualanProduk(): HasMany
    {
        return $this->hasMany(DetailPenjualanProduk::class, 'id_penjualan', 'id_penjualan');
    }
}