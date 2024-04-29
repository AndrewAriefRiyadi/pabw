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
                    <p class=" text-xl font-bold">{{$produk->nama}}</p>
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
                    <div class="flex flex-row gap-4 py-4">
                        <div class="flex flex-row gap-4">
                            <img src="{{asset('storage/'.$produk->foto)}}" class="object-cover h-64 w-64 p-4 bg-gray-400">
                            <div class="flex flex-col gap-4">
                                <p> -- RATING -- </p>
                                <p class=" font-bold ">Rp {{$produk->harga}}</p>
                                <p class=" font-bold ">Stok = {{$produk->stok}}</p>
                                <p class=" font-bold ">Status Stok =  @if ($produk->status_stok == 1)
                                    Tersedia
                                @else
                                Tidak Tersedia
                                @endif</p>
                                <form id="formKeranjang" action="/keranjang" method="POST" >
                                    @csrf
                                    <input type="hidden" name="id_produk" value="{{ $produk->id }}">
                                    <input type="number" name="jumlah" value="1" min="1">
                                    <button type="submit">Tambah ke Keranjang</button>
                                </form>
                                @if (Auth::id() == $produk->id_user)
                                <a href="{{$produk->id}}/edit" class="px-4 py-2 rounded bg-yellow-300 w-fit"> Edit </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>