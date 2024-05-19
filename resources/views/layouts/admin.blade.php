<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-gray-100 flex flex-col">
            <div class="flex items-center justify-center h-20 border-b border-gray-700">
                <h1 class="text-2xl font-bold">MyThrift</h1>
            </div>
            <nav class="flex-grow p-4">
                <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('admin.users') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700">Users</a>
                <a href="{{ route('admin.produks') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700">Produks</a>
                <a href="/" class="text-white block py-2.5 px-4 rounded hover:bg-gray-700">Back to Home</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-grow p-6">
            <header class="flex justify-between items-center py-4 px-6 bg-white border-b-4 border-gray-200">
                <h2 class="text-3xl font-semibold text-gray-800">Admin</h2>
                <div class="flex items-center">
                    <div class="relative">
                        <button id="dropdownButton" class="relative z-10 block p-2 bg-white border rounded-full shadow focus:outline-none">
                            <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 110-4 2 2 0 010 4z"/><path fill-rule="evenodd" d="M.458 8.042A9 9 0 1116.25 2.13L19.6.206a.75.75 0 01.93 1.127l-3.522 3.48A8.963 8.963 0 0118 9a9 9 0 11-17.542-.958z" clip-rule="evenodd"/></svg>
                        </button>
                        <div id="dropdownMenu" class="hidden absolute right-0 z-20 w-48 py-2 mt-2 bg-white border rounded-lg shadow-xl">
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Profile</a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</a>
                        </div>
                    </div>
                </div>
            </header>
            <main class="mt-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dropdownButton = document.getElementById('dropdownButton');
            var dropdownMenu = document.getElementById('dropdownMenu');
            
            dropdownButton.addEventListener('click', function() {
                dropdownMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', function(event) {
                if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
