<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;

class ProdukController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $produks = Produk::with('kategori')->paginate(10);
        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        // dd('Store method reached!', $request->all());
        try {
            $validatedData = $request->validate([
                'nama_produk' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'harga_beli' => 'required|numeric|min:0',
                'harga_jual' => 'required|numeric|min:0|gte:harga_beli',
                'stok' => 'required|integer|min:0',
                'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'kategori_id' => 'required|exists:kategori,id',
                'aktif' => 'boolean',
            ]);

            // dd('Validated Data:', $validatedData);

            if ($request->hasFile('gambar_produk')) {
                $imagePath = $request->file('gambar_produk')->store('public/foto_produk');
                $validatedData['gambar_produk'] = str_replace('public/', 'storage/', $imagePath);
            } else {
                $validatedData['gambar_produk'] = null;
            }

            // dd('Final Data for Create:', $validatedData);

            $validatedData['aktif'] = $request->has('aktif');

            Produk::create($validatedData);

            return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');

        } catch (ValidationException $e) {
            // dd('Validation Error:', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // dd('General Error:', $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan produk: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Produk $produk)
    {
        $produk->load('kategori');
        return view('produk.show', compact('produk'));
    }

    public function edit(Produk $produk)
    {
        $kategoris = Kategori::all();
        return view('produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, Produk $produk)
    {
        try {
            $validatedData = $request->validate([
                'nama_produk' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'harga_beli' => 'required|numeric|min:0',
                'harga_jual' => 'required|numeric|min:0|gte:harga_beli',
                'stok' => 'required|integer|min:0',
                'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'kategori_id' => 'required|exists:kategori,id',
                'aktif' => 'boolean',
            ]);

            if ($request->hasFile('gambar_produk')) {
                if ($produk->gambar_produk) {
                    Storage::delete(str_replace('storage/', 'public/', $produk->gambar_produk));
                }
                $imagePath = $request->file('gambar_produk')->store('public/foto_produk');
                // dd('Image Path from store(): ', $imagePath);
                $validatedData['gambar_produk'] = str_replace('public/', 'storage/', $imagePath);
            } else {
                $validatedData['gambar_produk'] = $produk->gambar_produk; 
            }

            $validatedData['aktif'] = $request->has('aktif');

            // dd($validatedData);

            $produk->update($validatedData);

            return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui produk: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Produk $produk)
    {
        try {
            if ($produk->gambar_produk) {
                Storage::delete(str_replace('storage/', 'public/', $produk->gambar_produk));
            }
            $produk->delete();

            return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus produk: ' . $e->getMessage());
        }
    }
}