@extends('layouts.base')
@push('styles')
    <link id="color-link" rel="stylesheet" type="text/css" href="{{ asset('assets/css/demo2.css') }}">
@endpush
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-col bg-gray-100 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6 text-center">Pesanan</h1>
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
                    <div class="flex flex-col gap-4 py-4">
                        @foreach($keranjangs as $keranjang)
                            <div class="bg-white shadow-md p-6 rounded-lg mb-6">
                                <h4 class="text-lg font-semibold mb-4">Pesanan #{{ $keranjang->id }}</h4>
                                @if(isset($keranjangProduks[$keranjang->id]))
                                    <ul class="list-disc pl-5 mb-4">
                                        @foreach($keranjangProduks[$keranjang->id] as $produk)
                                            <li class="mb-2">
                                                <span class="font-medium">{{ $produk->produk->nama }}</span> 
                                                <span>(Jumlah: {{ $produk->jumlah }})</span> 
                                                <span>(Status: {{$produk->status->status}})</span>
                                                @if ($produk->status->id == 6)
                                                    <form action="/pesanan/{{Auth::user()->username}}" method="POST" class="mt-2">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="id_pivot" value="{{$produk->id_pivot}}">
                                                        <button type="submit" class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600">Pesanan Sudah Diterima</button>
                                                    </form>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                <div class="mt-4">
                                    <h4 class="text-lg font-semibold">Jumlah Barang: {{$keranjang->jumlah_total}}</h4>
                                    <h4 class="text-lg font-semibold">Harga Total: Rp {{ number_format($keranjang->harga_total, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
