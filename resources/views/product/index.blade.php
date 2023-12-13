@extends('layouts.layout')

@section('content')
    <div class="header container ">
        <p class="mt-4">Tambahkan menu makanan yang ada diresto</p>
        <div class="container mt-4 bg-white">
            <div class="mt-2">
                <a href="/products/create" class="btn btn-primary mt-3">Tambah Produk</a>
            </div>
            <br>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Foto</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->nama }}</td>
                                <td>
                                    @if ($product->foto)
                                        <img src="{{ asset('foto_produk/' . $product->foto) }}" alt="{{ $product->nama }}" style="max-width: 100px;">
                                    @else
                                        <span>Tidak Ada Foto</span>
                                    @endif
                                </td>
                                <td>Rp. {{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="post" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
