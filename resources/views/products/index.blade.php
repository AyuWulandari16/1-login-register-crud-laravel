@extends('layouts.app')
  
@section('title', 'Home Product')
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">List Product</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add Product</a>
    </div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Price</th>
                <th>Product Code</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>+
            <!-- memeriksa apakah ada produk yang ada dalam daftar -->
            <!-- Jika jumlah produk yang diterima ($product) lebih dari 0 (artinya ada produk yang tersedia), -->
            <!-- maka blok kode yang ada di dalam pernyataan ini akan dieksekusi -->
            @if($product->count() > 0)
                <!-- ika ada produk yang ada, maka kode ini akan melakukan perulangan (loop) melalui setiap produk dalam daftar -->
                @foreach($product as $fashion)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $fashion->title }}</td>
                        <td class="align-middle">{{ $fashion->price }}</td>
                        <td class="align-middle">{{ $fashion->product_code }}</td>
                        <td class="align-middle">{{ $fashion->description }}</td>  
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('products.show', $fashion->id) }}" type="button" class="btn btn-secondary">Detail</a>
                                <a href="{{ route('products.edit', $fashion->id)}}" type="button" class="btn btn-warning">Edit</a>
                                <form action="{{ route('products.destroy', $fashion->id) }}" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-0">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5">Product not found</td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection