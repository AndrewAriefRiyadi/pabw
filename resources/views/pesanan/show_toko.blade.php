@extends('layouts.base')
@push('styles')
    <link id="color-link" rel="stylesheet" type="text/css" href="{{ asset('assets/css/demo2.css') }}">
@endpush
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-col bg-gray-100 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6 text-center">Pesanan Toko</h1>
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
                            <div class="bg-white shadow-md p-6 rounded-lg">
                                <h4 class="text-lg font-semibold mb-4">Pesanan #{{ $keranjang->id }}</h4>
                                @if(isset($keranjangProduks[$keranjang->id]))
                                    <ul class="list-disc pl-5 mb-4">
                                        @foreach($keranjangProduks[$keranjang->id] as $produk)
                                            <li class="mb-2">
                                                <span class="font-medium">{{ $produk->produk->nama }}</span> 
                                                <span>(Jumlah: {{ $produk->jumlah }})</span> 
                                                <p class="text-gray-600">(Status: {{$produk->status_kurir->status}})</p>
                                                <form action="/kurir/barang" method="POST" class="mt-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="id_pivot" value="{{$produk->id_pivot}}">
                                                    @if (!empty($produk->list_status))
                                                        <select name="id_status" class="border border-gray-300 rounded p-1">
                                                            @foreach ($produk->list_status as $list)
                                                                <option value="{{ $list->id }}">{{ $list->status }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button type="submit" class="ml-2 p-2 bg-blue-500 text-white rounded hover:bg-blue-600">Update</button>
                                                    @endif
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                <h4 class="text-lg font-semibold">Jumlah Barang: {{$keranjang->jumlah_total}}</h4>
                                <h4 class="text-lg font-semibold">Harga Total: Rp {{ number_format($keranjang->harga_total, 0, ',', '.') }}</h4>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
