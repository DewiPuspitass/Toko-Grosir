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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string("nama_produk");
            $table->string("deskripsi");
            $table->string("harga_beli");
            $table->string("harga_jual");
            $table->string("stok");
            $table->string("gambar_produk");
            $table->foreignId("kategori_id")->constrained("kategori")->onDelete("cascade");
            $table->boolean("aktif");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
