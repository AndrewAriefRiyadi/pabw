@extends('layouts.base')
@push('styles')
    <link id="color-link" rel="stylesheet" type="text/css" href="{{ asset('assets/css/demo2.css') }}">
@endpush
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-col bg-gray-300 text-gray-900 ">
                    <h1 class=" font-bold"> DASHBOARD ADMIN </h1>
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
                        <h2>Table User</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Alamat</th>
                                    <th>No HP</th>
                                    <th>Saldo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->alamat }}</td>
                                    <td>{{ $user->no_hp }}</td>
                                    <td>{{ $user->saldo }}</td>
                                    <td>
                                        <div class="flex flex-col">
                                            <button class="w-fit" onclick="openPopup('{{ $user->username }}', {{ $user->saldo }})">Edit Saldo</button>
                                        </div> 
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <h3> LOGS </h3>
                        @foreach ($logs as $log)
                            <p>{{$log->deskripsi}}</p>
                        @endforeach
                        <div id="popup" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 border border-gray-300 rounded shadow-lg z-10 hidden">
                            <h3 class="text-xl mb-4">Edit Saldo Pengguna</h3>
                            <form id="saldoForm" action="/admin/updateSaldo" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <p id='username_text'></p>
                                    <p id='old_saldo'></p>
                                    <input type="hidden" id='username' name='username' value="">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="saldo">Saldo Baru:</label>
                                    <input type="number" id="saldo" name="saldo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                </div>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                            </form>
                            <button onclick="closePopup()" class="mt-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Tutup</button>
                        </div>
                        <!-- Overlay untuk latar belakang gelap -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="overlay" class="fixed top-0 left-0 w-full h-full bg-black opacity-50 z-5 hidden"></div>
    <script>
        // Fungsi untuk membuka pop-up
        function openPopup(username, saldo) {
            document.getElementById('username_text').textContent = username;
            document.getElementById('old_saldo').textContent = saldo;
            document.getElementById('username').value = username;
            
            document.getElementById('popup').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        // Fungsi untuk menutup pop-up
        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }
    </script>
@endsection