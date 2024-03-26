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
                        <div class="flex flex-row gap-4">
                            {{-- <img src="{{asset('storage/'.$produk->foto)}}" class="object-cover h-64 w-64 p-4 bg-gray-400">
                            <div class="flex flex-col gap-4">
                                <p> -- RATING -- </p>
                                <p class=" font-bold ">Rp {{$produk->harga}}</p>
                                <p class=" font-bold ">Stok = {{$produk->stok}}</p>
                                <form id="formKeranjang">
                                    @csrf
                                    <input type="hidden" name="id_produk" value="{{ $produk->id }}">
                                    <input type="number" name="jumlah" value="1" min="1">
                                    <button type="submit">Tambah ke Keranjang</button>
                                </form>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>