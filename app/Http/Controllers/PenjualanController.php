<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class PenjualanController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:penjualan-list', ['only' => ['index','show']]);
         $this->middleware('permission:penjualan-create', ['only' => ['create','store']]);
         $this->middleware('permission:penjualan-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:penjualan-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $penjualans = Penjualan::with('pengguna', 'detailPenjualanProduk.produk')->paginate(10);
        return view('penjualans.index', compact('penjualans'));
    }

    public function create()
    {
        $admins = User::all();
        return view('penjualans.create', compact('admins'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'tanggal_penjualan' => 'required|date',
                'total_pendapatan' => 'required|numeric|min:0',
                'total_keuntungan' => 'required|numeric|min:0',
            ]);

            Penjualan::create($validatedData);

            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil ditambahkan!');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan penjualan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Penjualan $penjualan)
    {
        $penjualan->load('pengguna', 'detailPenjualanProduk.produk');
        return view('penjualans.show', compact('penjualan'));
    }

    public function edit(Penjualan $penjualan)
    {
        $admins = User::all();
        return view('penjualans.edit', compact('penjualan', 'admins'));
    }

    public function update(Request $request, Penjualan $penjualan)
    {
        try {
            $validatedData = $request->validate([
                'tanggal_penjualan' => 'required|date',
                'total_pendapatan' => 'required|numeric|min:0',
                'total_keuntungan' => 'required|numeric|min:0',
            ]);

            // dd($validatedData);
            $penjualan->update($validatedData);

            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil diperbarui!!');

        } catch (ValidationException $e) {
            // dd('Validation Error:', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // dd('General Error:', $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui penjualan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Penjualan $penjualan)
    {
        try {
            $penjualan->delete();

            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus penjualan: ' . $e->getMessage());
        }
    }
}