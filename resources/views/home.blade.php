<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800  leading-tight">
            Home
        </h2>
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if ($errors->any())
                <div class="alert alert-danger p-4 bg-red-300">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="p-6 text-gray-900 ">
                    <div class=" flex flex-col shadow-sm">
                        <p class=" font-bold text-4xl font-serif text-center py-4">NEW ARRIVAL</p>
                        @foreach ($produks as $produk)
                        <div class="flex flex-row justify-center gap-8 py-4">
                            <div class="flex flex-row gap-4 py-4">
                                <div class="flex flex-col gap-1">
                                    <img src="{{asset('storage/'.$produk->foto)}}" class="object-cover h-64 w-64 p-4 bg-gray-400 rounded">
                                    <p class=" font-bold ">{{$produk->nama}}</p>
                                    <p> -- RATING -- </p>
                                    <p class=" font-bold ">Rp {{$produk->harga}}</p>
                                </div>
                            </div>
                        </div>
                        <a href="#" class=" text-center py-2 px-8 border border-gray-500 w-fit self-center rounded-full mb-8">
                            View All
                        </a>
                        @endforeach
                    </div>
                    <div class=" flex flex-col shadow-sm">
                        <p class=" font-bold text-4xl font-serif text-center py-4">TOP SELLING</p>
                        @foreach ($produks as $produk)
                        <div class="flex flex-row justify-center gap-8 py-4">
                            <div class="flex flex-row gap-4 py-4">
                                <div class="flex flex-col gap-1">
                                    <img src="{{asset('storage/'.$produk->foto)}}" class="object-cover h-64 w-64 p-4 bg-gray-400 rounded">
                                    <p class=" font-bold ">{{$produk->nama}}</p>
                                    <p> -- RATING -- </p>
                                    <p class=" font-bold ">Rp {{$produk->harga}}</p>
                                </div>
                            </div>
                        </div>
                        <a href="#" class=" text-center py-2 px-8 border border-gray-500 w-fit self-center rounded-full mb-8">
                            View All
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
