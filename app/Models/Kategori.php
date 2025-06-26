<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_kategori',
    ];

    /**
     * Get the products for the category.
     */
    public function produk(): HasMany
    {
        return $this->hasMany(Produk::class, 'id', 'id_kategori');
    }
}
