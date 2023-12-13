@extends('layouts.layout')

@section('content')

    <div class="container mt-4">
        <div class="card container">
            <div class="row mt-3">
                <p class="text-primary">Edit menu</p>

                <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama:</label>
                        <input type="text" name="nama" class="form-control" value="{{ $product->nama }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto:</label>
                        <br>
                        @if ($product->foto)
                            <img src="{{ asset('foto_produk/' . $product->foto) }}" alt="{{ $product->nama }}" style="max-width: 100px;">
                        @else
                            <span>Tidak Ada Foto</span>
                        @endif
                        <br>
                        <label for="foto" class="form-label">Upload Foto Baru:</label>
                        <input type="file" name="foto" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga:</label>
                        <input type="number" name="harga" class="form-control" value="{{ $product->harga }}" step="0.01" required>
                    </div>
                    <div class="mb-3 mt-2 d-flex justify-content-end">

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

