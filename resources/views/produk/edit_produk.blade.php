@extends('layouts.base')
@push('styles')
<link id="color-link" rel="stylesheet" type="text/css" href="assets/css/demo2.css">
<style>
    nav svg{
        height: 20px;
    }
    .product-box .product-details h5 {
        width: 100%
    }
</style>
@endpush
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-col gap-4 bg-gray-300 text-gray-900 ">
                    <p class=" text-xl font-bold">Create Produk</p>
                    <form action="/produk/{{Auth::user()->username}}/{{$produk->id}}/edit" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="rounded">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama Produk</label>
                            <input value="{{$produk->nama}}" type="text" name="nama" id="nama" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Nama Produk" required>
                        </div>
                        <div class="mb-4">
                            <label for="harga" class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                            <input value="{{$produk->harga}}" type="number" name="harga" id="harga" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Harga" required>
                        </div>
                        <div class="mb-4">
                            <label for="foto" class="block text-gray-700 text-sm font-bold mb-2">Foto</label>
                            <input type="file" name="foto" id="foto" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" rows="4" placeholder="foto"></input>
                        </div>
                        <div class="mb-4">
                            <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" rows="4" placeholder="Deskripsi" required> {{$produk->deskripsi}} </textarea>
                        </div>
                        <div class="mb-4">
                            <label for="stok" class="block text-gray-700 text-sm font-bold mb-2">Stok</label>
                            <input value="{{$produk->stok}}"" type="number" name="stok" id="stok" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Stok" required>
                        </div>
                        <div class="mt-8">
                            <button type="submit" class="w-fit bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Simpan</button>
                        </div>
                    </div>
                    </form>
                    <form action="/produk/{{Auth::user()->username}}/{{$produk->id}}/edit" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('delete')
                        <button type="submit" class="w-fit bg-red-500 text-white py-2 px-4 rounded-md "> DELETE </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection