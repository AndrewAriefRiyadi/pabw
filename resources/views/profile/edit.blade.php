@extends('layouts.base')
@section('content')
    <div class="max-w-2xl mx-auto p-5 bg-white rounded-lg shadow-md mt-10">
        <h1 class="text-2xl font-bold mb-4">Profile Page</h1>

        @if (session('message'))
            <div class="mb-4 p-3 bg-blue-100 text-blue-700 rounded">
                {{ session('message') }}
            </div>
        @endif

        @if (auth()->user()->hasVerifiedEmail())
            <p class="text-gray-700">Email sudah terverifikasi</p>
        @else
            <p class="py-4">Anda belum verifikasi email Anda. Verifikasi sekarang!</p>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Verifikasi Email
                </button>
            </form>
        @endif
    </div>
@endsection
