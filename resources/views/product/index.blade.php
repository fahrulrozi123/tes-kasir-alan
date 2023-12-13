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
                <div class="table-responsive">
                    <table id="productTable" class="table table-striped">
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
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready(function () {
            $('#productTable').DataTable();
        });
    </script>
@endsection
