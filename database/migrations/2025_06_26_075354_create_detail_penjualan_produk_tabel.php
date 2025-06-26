<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_penjualan_produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penjualan')->constrained('penjualan')->onDelete('cascade');
            $table->foreignId('id_produk')->constrained('produk')->onDelete('cascade');
            $table->integer('jumlah_terjual');
            $table->decimal('harga_jual', 15, 2);
            $table->decimal('harga_beli', 15, 2);
            $table->decimal('subtotal_pendapatan', 15, 2);
            $table->decimal('subtotal_keuntungan', 15, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualan_produk');
    }
};
