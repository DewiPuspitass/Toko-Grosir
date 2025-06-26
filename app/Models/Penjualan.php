<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penjualan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'penjualan';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tanggal_penjualan',
        'total_pendapatan',
        'total_keuntungan',
        'id_admin',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_penjualan' => 'date',
        'total_pendapatan' => 'decimal:2',
        'total_keuntungan' => 'decimal:2',
    ];

    /**
     * Get the user that inputted the sale.
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_admin', 'id');
    }

    /**
     * Get the detail products for the sale.
     */
    public function detailPenjualanProduk(): HasMany
    {
        return $this->hasMany(DetailPenjualanProduk::class, 'id_penjualan', 'id_penjualan');
    }
}