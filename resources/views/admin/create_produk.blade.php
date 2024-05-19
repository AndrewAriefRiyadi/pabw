@extends('layouts.admin')
@push('styles')
    <link id="color-link" rel="stylesheet" type="text/css" href="assets/css/demo2.css">
    <style>
        nav svg {
            height: 20px;
        }

        .product-box .product-details h5 {
            width: 100%
        }
    </style>
@endpush

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-col gap-4 text-gray-900 ">
                    @if (session('success'))
                        <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
                            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path
                                    d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z" />
                            </svg>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            <strong class="font-bold">Error! </strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                <svg class="fill-current h-6 w-6 text-red-500" role="button"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <title>Close</title>
                                    <path
                                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                                </svg>
                            </span>
                        </div>
                    @endif
                    <p class=" text-xl font-bold">Create Produk</p>
                    <form action="/admin/produks/create" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="rounded">
                            <div class="mb-4">
                                <label for="id_user" class="block text-gray-700 text-sm font-bold mb-2">User</label>
                                <select name="id_user">
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}">{{$user->username}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama Produk</label>
                                <input type="text" name="nama" id="nama"
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                    placeholder="Nama Produk" required>
                            </div>
                            <div class="mb-4">
                                <label for="harga" class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                                <input type="number" name="harga" id="harga"
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                    placeholder="Harga" required>
                            </div>
                            <div class="mb-4">
                                <label for="foto" class="block text-gray-700 text-sm font-bold mb-2">Foto</label>
                                <input type="file" name="foto" id="foto"
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                    rows="4" placeholder="foto" required></input>
                            </div>
                            <div class="mb-4">
                                <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi"
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" rows="4"
                                    placeholder="Deskripsi" required></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="stok" class="block text-gray-700 text-sm font-bold mb-2">Stok</label>
                                <input type="number" name="stok" id="stok"
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                    placeholder="Stok" required>
                            </div>
                            <div class="mt-8">
                                <button type="submit"
                                    class="w-fit bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
