<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga_beli',
        'harga_jual',
        'stok',
        'satuan',
        'id_kategori',
        'gambar_produk',
        'aktif',
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'stok' => 'integer',
        'aktif' => 'boolean',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function detailPenjualanProduk(): HasMany
    {
        return $this->hasMany(DetailPenjualanProduk::class, 'id_produk', 'id_produk');
    }
}
