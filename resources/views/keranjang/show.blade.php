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
                    <h1 class=" font-bold"> KERANJANG </h1>
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
                        @empty($produks)
                            <p> Anda belum memasukkan barang ke dalam keranjang</p>
                        @endempty
                        @foreach ($produks as $produk)
                        <div class="flex flex-row gap-4">
                            <p>{{$produk->produk->nama}}</p>
                            <p>{{$produk->jumlah}}</p>
                            <form action="/keranjang/{{Auth::user()->username}}/kurang" method="post">
                                @csrf
                                @method('put')
                                <input type="hidden" name="id_produk" value="{{$produk->produk->id}}">
                                <button type="submit" class=" bg-blue-300 px-2 rounded center"> - </button>
                            </form>
                            <form action="/keranjang/{{Auth::user()->username}}/tambah" method="post">
                                @csrf
                                @method('put')
                                <input type="hidden" name="id_produk" value="{{$produk->produk->id}}">
                                <button type="submit" class=" bg-green-400 px-2 rounded center"> + </button>
                            </form>
                            <form action="/keranjang/{{Auth::user()->username}}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id_produk" value="{{$produk->produk->id}}">
                                <button type="submit" class=" bg-red-400 p-2 rounded center"> DELETE </button>
                            </form>
                        </div>
                        @endforeach
                        @isset($keranjang)
                        <p class=" self-end">Jumlah Barang = {{$keranjang->jumlah_total}}</p>
                        <p class=" self-end">Harga Total = {{$keranjang->harga_total}}</p>
                            <form action="/pesanan/{{Auth::user()->username}}" method="post" class="self-end">
                                @csrf
                                <input type="hidden" name="id_keranjang" value="{{$keranjang->id}}">
                                <button type="submit" class=" bg-yellow-400 p-2 rounded center"> Buat Pesanan </button>
                            </form>
                        @endisset
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>