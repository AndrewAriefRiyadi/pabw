@extends('layouts.base')
@push('styles')
    <link id="color-link" rel="stylesheet" type="text/css" href="{{ asset('assets/css/demo2.css') }}">
@endpush
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-col bg-gray-300 text-gray-900 ">
                    <h1 class=" font-bold"> PESANAN TOKO </h1>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="flex flex-col gap-4 py-4">
                        @foreach($keranjangs as $keranjang)
                            <div class="bg-white shadow p-4 rounded">
                                <h4>Pesanan {{ $keranjang->id }}</h4>
                                @if(isset($keranjangProduks[$keranjang->id]))
                                    <ul>
                                        @foreach($keranjangProduks[$keranjang->id] as $produk)
                                            <li>
                                                {{ $produk->produk->nama }} (Jumlah: {{ $produk->jumlah }})
                                            </li>
                                            <p> (Status: {{$produk->status_kurir->status}}) </p>
                                            <form action="/kurir/barang" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name ='id_pivot' value={{$produk->id_pivot}}>
                                                @if (!empty($produk->list_status))
                                                    <select name="id_status">
                                                        @foreach ($produk->list_status as $list)
                                                            <option value="{{ $list->id }}">{{ $list->status }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="p-2 bg-blue-300 rounded">Update</button>
                                                @endif
                                            </form>
                                        @endforeach
                                    </ul>
                                @endif
                                <h4>Jumlah Barang = {{$keranjang->jumlah_total}}</h4>
                                <h4>Harga Total = {{$keranjang->harga_total}}</h4>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection