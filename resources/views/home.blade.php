<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800  leading-tight">
            Home
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 ">
                    <p class=" font-bold text-xl">PRODUK</p>
                    @foreach ($produks as $produk)
                        <div class="flex flex-row gap-4 py-4">
                            <div class="flex flex-col gap-1">
                                <img src="{{asset('storage/'.$produk->foto)}}" class="object-cover h-64 w-64 p-4 bg-gray-400">
                                <p class=" font-bold ">{{$produk->nama}}</p>
                                <p> -- RATING -- </p>
                                <p class=" font-bold ">Rp {{$produk->harga}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
