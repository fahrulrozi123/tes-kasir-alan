<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = new Product;
        $product->nama = $request->nama;
        $product->harga = $request->harga;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->move(public_path('foto_produk'), uniqid() . '_' . $request->file('foto')->getClientOriginalName());
            $product->foto = basename($fotoPath);
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Daftar menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->nama = $request->nama;
        $product->harga = $request->harga;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->move(public_path('foto_produk'), uniqid() . '_' . $request->file('foto')->getClientOriginalName());
            $product->foto = basename($fotoPath);
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Daftar menu berhasil diperbarui');
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Daftar menu tidak ditemukan');
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Daftar menu berhasil dihapus');
    }
}
