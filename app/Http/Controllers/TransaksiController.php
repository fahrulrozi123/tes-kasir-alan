<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class TransaksiController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('transaksi.index', compact('products'));
    }

    public function addToOrder(Request $request)
    {
        $productId = $request->input('productId');
        $quantity = $request->input('quantity');

        // Tingkatkan jumlah produk yang ada di pesanan
        Product::where('id', $productId)->increment('quantity', $quantity);

        return response()->json(['message' => 'Pesanan berhasil ditambahkan']);
    }
}

