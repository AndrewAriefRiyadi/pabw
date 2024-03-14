<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800  leading-tight">
            Toko-Ku
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-col bg-gray-300 text-gray-900 ">
                    @if(session('success'))
                        <div class="alert alert-success p-4 bg-green-300">
                            {{ session('success') }}
                        </div>
                    @endif
                    <p class=" text-xl font-bold">List Produks</p>
                    @if ($produks->isEmpty())
                        <p class="text-center"> Anda belum menjual produk apapun. <a href="/produk/create" class=" underline text-blue-400"> Tambahkan Produk</a></p>
                    @else
                    @if (Auth::user() == $user)
                    <a href="/store/{{$user->username}}/create" class=" underline text-blue-400"> Tambahkan Produk</a>
                    @endif
                        @foreach ($produks as $produk)
                            <div class="flex flex-row gap-4 py-4">
                                <div class="flex flex-col gap-1">
                                    <a href="/">
                                        <img src="{{asset('storage/'.$produk->foto)}}" class="object-cover h-64 w-64 p-4 bg-gray-400">
                                        <p class=" font-bold pt-4 ">{{$produk->nama}}</p>
                                    </a>
                                    <p> -- RATING -- </p>
                                    <p class=" font-bold ">Rp {{$produk->harga}}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>