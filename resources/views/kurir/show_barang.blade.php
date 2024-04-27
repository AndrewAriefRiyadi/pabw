<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800  leading-tight">
            Show Produk
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-col bg-gray-300 text-gray-900 ">
                    <h1 class=" font-bold"> PESANAN YANG PERLU DI ANTAR </h1>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="flex flex-col gap-4 py-4">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @foreach($keranjangs as $keranjang)
                            <div class="bg-white shadow p-4 rounded">
                                <h2>Pesanan {{ $keranjang->id }}</h2>
                                @if(isset($keranjangProduks[$keranjang->id]))
                                    <ul>
                                        @foreach($keranjangProduks[$keranjang->id] as $produk)
                                            <li>
                                                {{ $produk->produk->nama }} (Jumlah: {{ $produk->jumlah }}) (Nama Penjual: {{$produk->penjual->name}}) (Alamat Penjual: {{$produk->penjual->alamat}}) (Status: {{$produk->status_kurir->status}})
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                <h2>Jumlah Barang = {{$keranjang->jumlah_total}}</h2>
                                <h2>Harga Total = {{$keranjang->harga_total}}</h2>
                                @if(isset($keranjangUsers[$keranjang->id]))
                                    <p>Info Pembeli</p>
                                    <p> Nama = {{ $keranjangUsers[$keranjang->id]->name }} </p>
                                    <p> Alamat = {{$keranjangUsers[$keranjang->id]->alamat}}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>