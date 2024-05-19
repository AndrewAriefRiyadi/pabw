@extends('layouts.base')
@push('styles')
    <link id="color-link" rel="stylesheet" type="text/css" href="{{ asset('assets/css/demo2.css') }}">
@endpush
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gray-100 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6 text-center">Pesanan yang Perlu Diantar</h1>
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    @isset($keranjangs)
                        @foreach($keranjangs as $keranjang)
                            <div class="bg-white shadow-md p-6 rounded-lg mb-6">
                                <h2 class="text-xl font-semibold mb-4">Pesanan #{{ $keranjang->id }}</h2>
                                @if(isset($keranjangProduks[$keranjang->id]))
                                    <ul class="list-disc pl-5 mb-4">
                                        @foreach($keranjangProduks[$keranjang->id] as $produk)
                                            <li class="mb-2">
                                                <span class="font-medium">{{ $produk->produk->nama }}</span> 
                                                <span>(Jumlah: {{ $produk->jumlah }})</span> 
                                                <span>(Nama Penjual: {{$produk->penjual->name}})</span> 
                                                <span>(Alamat Penjual: {{$produk->penjual->alamat}})</span>
                                                <div class="mt-2">
                                                    <span class="font-medium">Status:</span> {{$produk->status_kurir->status}}
                                                </div>
                                                <form action="/kurir/barang" method="POST" class="mt-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name='id_pivot' value="{{ $produk->id_pivot }}">
                                                    @if (!empty($produk->list_status))
                                                        <select name="id_status" class="p-2 border rounded mr-2">
                                                            @foreach ($produk->list_status as $list)
                                                                <option value="{{ $list->id }}">{{ $list->status }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button type="submit" class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600">Update</button>
                                                    @endif
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                <div class="mt-4">
                                    <h2 class="text-lg font-semibold">Jumlah Total Barang: {{$keranjang->jumlah_total}}</h2>
                                    <h2 class="text-lg font-semibold">Harga Total: Rp {{ number_format($keranjang->harga_total, 0, ',', '.') }}</h2>
                                </div>
                                @if(isset($keranjangUsers[$keranjang->id]))
                                    <div class="mt-4">
                                        <h3 class="text-lg font-semibold">Info Pembeli</h3>
                                        <p>Nama: {{ $keranjangUsers[$keranjang->id]->name }}</p>
                                        <p>Alamat: {{$keranjangUsers[$keranjang->id]->alamat}}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endisset
                </div>
            </div>
        </div>
    </div>
@endsection
