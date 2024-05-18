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
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
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
                    <p class=" text-xl font-bold">Create User</p>
                    <form action="/admin/users/create" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="rounded">
                            <div class="mb-4">
                                <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama User</label>
                                <input value="" type="text" name="name" id="name"
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                    placeholder="Nama Produk" required>
                            </div>
                            <div class="mb-4">
                                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                                <input value="" type="text" name="username" id="username"
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                    placeholder="username" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                                <input value="" type="password" name="password" id="password"
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                    placeholder="password" required>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">E-mail</label>
                                <input value="" type="text" name="email" id="email"
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                    placeholder="email" required>
                            </div>
                            <div class="mb-4">
                                <label for="alamat" class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
                                <input value="" type="text" name="alamat" id="alamat"
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                    placeholder="alamat" required>
                            </div>
                            <div class="mb-4">
                                <label for="no_hp" class="block text-gray-700 text-sm font-bold mb-2">No HP</label>
                                <input value=" " type="number" name="no_hp" id="no_hp"
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                    placeholder="no_hp" required>
                            </div>
                            <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                            <select name="role" id="role">
                                <option value="admin">admin</option>
                                <option value="user">user</option>
                                <option value="kurir">kurir</option>
                            </select>
                            <div class="mt-8">
                                <button type="submit"
                                    class="w-fit bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Simpan</button>
                            </div>
                        </div>
                    </form>
                    {{-- @role('admin')
                        <form action="/user/edit/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('delete')
                            <button type="submit" class="w-fit bg-red-500 text-white py-2 px-4 rounded-md "> Suspend </button>
                        </form>
                    @endrole --}}
                </div>
            </div>
        </div>
    </div>
@endsection
