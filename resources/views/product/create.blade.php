@extends('layouts.layout')

@section('content')
    <div class="container mt-4">
        <div class="card container">
            <div class="row mt-3">
                <p class="text-primary">Tambahkan menu</p>

                <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama:</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto:</label>
                        <input type="file" name="foto" class="form-control">
                    </div>
                    <div class="row mt-2">
                        <label for="foto" class="form-label">Harga:</label>
                        <div class="col-md-12">
                            <div class="rupiah-container">
                                <span class="rupiah-label">Rp</span>
                                <input type="number" name="harga" class="form-control" step="0.01" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 mt-2 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
