<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPenjualanProduk extends Model
{
    use HasFactory;
    protected $table = 'detail_penjualan_produk'; 
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_penjualan',
        'id_produk',
        'jumlah_terjual',
        'harga_jual',
        'harga_beli',
        'subtotal_pendapatan',
        'subtotal_keuntungan',
    ];

    protected $casts = [
        'jumlah_terjual' => 'integer',
        'harga_jual' => 'decimal:2',
        'harga_beli' => 'decimal:2',
        'subtotal_pendapatan' => 'decimal:2',
        'subtotal_keuntungan' => 'decimal:2',
    ];

    public function penjualan(): BelongsTo
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan', 'id');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id');
    }
}