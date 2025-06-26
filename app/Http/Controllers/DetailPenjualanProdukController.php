<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualanProduk;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DetailPenjualanProdukController extends Controller
{
    public function index()
    {
        $details = DetailPenjualanProduk::with('penjualan', 'produk')->paginate(10);
        return view('detail_penjualan_produks.index', compact('details'));
    }

    public function create()
    {
        $penjualans = Penjualan::all();
        $produks = Produk::all();
        return view('detail_penjualan_produks.create', compact('penjualans', 'produks'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_penjualan' => 'required|exists:penjualan,id',
                'id_produk' => 'required|exists:produk,id',
                'jumlah_terjual' => 'required|integer|min:1',
                'harga_jual' => 'required|numeric|min:0',
                'harga_beli' => 'required|numeric|min:0',
                'subtotal_pendapatan' => 'required|numeric|min:0',
                'subtotal_keuntungan' => 'required|numeric|min:0',
            ]);

            $produk = Produk::find($validatedData['id_produk']);
            if ($produk) {
                $validatedData['harga_jual'] = $produk->harga_jual;
                $validatedData['harga_beli'] = $produk->harga_beli;
                $validatedData['subtotal_pendapatan'] = $produk->harga_jual * $validatedData['jumlah_terjual'];
                $validatedData['subtotal_keuntungan'] = ($produk->harga_jual - $produk->harga_beli) * $validatedData['jumlah_terjual'];
            }

            // dd($validatedData);
            DetailPenjualanProduk::create($validatedData);

            return redirect()->route('detail_penjualan_produk.index')->with('success', 'Detail penjualan produk berhasil ditambahkan!');

        } catch (ValidationException $e) {
            dd('Validation Error:', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            dd('General Error:', $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan detail penjualan produk: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailPenjualanProduk $detailPenjualanProduk)
    {
        $detailPenjualanProduk->load('penjualan', 'produk');
        return view('detail_penjualan_produks.show', compact('detailPenjualanProduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailPenjualanProduk $detailPenjualanProduk)
    {
        $penjualans = Penjualan::all();
        $produks = Produk::all();
        return view('detail_penjualan_produks.edit', compact('detailPenjualanProduk', 'penjualans', 'produks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailPenjualanProduk $detailPenjualanProduk)
    {
        try {
            $validatedData = $request->validate([
                'id_penjualan' => 'required|exists:penjualans,id',
                'id_produk' => 'required|exists:produk,id',
                'jumlah_terjual' => 'required|integer|min:1',
            ]);

            $produk = Produk::find($validatedData['id_produk']);
            if ($produk) {
                $validatedData['harga_jual'] = $produk->harga_jual;
                $validatedData['harga_beli'] = $produk->harga_beli;
                $validatedData['subtotal_pendapatan'] = $produk->harga_jual * $validatedData['jumlah_terjual'];
                $validatedData['subtotal_keuntungan'] = ($produk->harga_jual - $produk->harga_beli) * $validatedData['jumlah_terjual'];
            }

            $detailPenjualanProduk->update($validatedData);

            return redirect()->route('detail_penjualan_produk.index')->with('success', 'Detail penjualan produk berhasil diperbarui!');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailPenjualanProduk $detailPenjualanProduk)
    {
        try {
            $detailPenjualanProduk->delete();
            return redirect()->route('detail_penjualan_produk.index')->with('success', 'Detail penjualan produk berhasil dihapus!');
        } catch (\Exception | QueryException $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus detail penjualan produk: ' . $e->getMessage());
        }
    }
}