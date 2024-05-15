@extends('layouts.base')
@push('styles')
<link id="color-link" rel="stylesheet" type="text/css" href="assets/css/demo2.css">
<style>
    nav svg{
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
                <div class="p-6 flex flex-col gap-4 bg-gray-300 text-gray-900 ">
                    <p class=" text-xl font-bold">Edit User</p>
                    <form action="/user/edit/{{$user->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="rounded">
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
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama User</label>
                            <input value="{{$user->name}}" type="text" name="name" id="name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="Nama Produk" required>
                        </div>
                        <div class="mb-4">
                            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                            <input value="{{$user->username}}" type="text" name="username" id="username" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="username" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">email</label>
                            <input value="{{$user->email}}" type="text" name="email" id="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="email" required>
                        </div>
                        <div class="mb-4">
                            <label for="alamat" class="block text-gray-700 text-sm font-bold mb-2">alamat</label>
                            <input value="{{$user->alamat}}" type="text" name="alamat" id="alamat" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="alamat" required>
                        </div>
                        <div class="mb-4">
                            <label for="no_hp" class="block text-gray-700 text-sm font-bold mb-2">no_hp</label>
                            <input value="{{$user->no_hp}}" type="number" name="no_hp" id="no_hp" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" placeholder="no_hp" required>
                        </div>
                        <div class="mt-8">
                            <button type="submit" class="w-fit bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Simpan</button>
                        </div>
                    </div>
                    </form>
                    @role('admin')
                    <form action="/user/edit/{{$user->id}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('delete')
                        <button type="submit" class="w-fit bg-red-500 text-white py-2 px-4 rounded-md "> Suspend </button>
                    </form>
                    @endrole
                </div>
            </div>
        </div>
    </div>
@endsection