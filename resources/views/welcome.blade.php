<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>VAK Marketplace</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    {{-- Ini akan menggunakan Vite jika tersedia, jika tidak, akan menggunakan CSS fallback --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased bg-slate-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">

    <header class="bg-white dark:bg-gray-800 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="text-2xl font-bold text-gray-800 dark:text-white">
                    <a href="{{ url('/') }}">VAK Marketplace</a>
                </div>

                @if (Route::has('login'))
                    <nav class="flex items-center gap-4 text-sm">
                        @auth
                            {{-- Tautan ke Dashboard --}}
                            <a
                                href="{{ url('/dashboard') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm leading-normal"
                            >
                                Dashboard
                            </a>

                            {{-- Tombol Log Out --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); this.closest('form').submit();"
                                       class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm leading-normal">
                                    Log Out
                                </a>
                            </form>
                        @else
                            {{-- Tautan Login --}}
                            <a
                                href="{{ route('login') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm leading-normal"
                            >
                                Log in
                            </a>

                            {{-- Tautan Register --}}
                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm leading-normal">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </div>
    </header>

    <main>
        <section class="bg-white dark:bg-gray-800">
            <div class="text-center py-20 px-4">
                <h1 class="text-5xl font-bold text-gray-800 dark:text-white">Selamat Datang di VAK Marketplace</h1>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">Temukan produk terbaik dengan penawaran luar biasa.</p>
                <div class="mt-6">
                    <a href="#produk" class="bg-blue-600 text-white font-semibold px-6 py-3 rounded-md transition hover:bg-blue-700">
                        Lihat Produk
                    </a>
                </div>
            </div>
        </section>

        <section id="produk" class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-10">Produk Unggulan</h2>

                {{-- Bagian ini sekarang dinamis, mengambil data dari database --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    
                    @forelse ($products as $product)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform transition duration-500 hover:scale-105">
                            <img class="w-full h-48 object-cover" src="{{ $product->image_url }}" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='https://placehold.co/400x300/e2e8f0/334155?text=Gambar+Rusak';">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white truncate" title="{{ $product->name }}">{{ $product->name }}</h3>
                                <p class="mt-2 text-gray-600 dark:text-gray-400">Rp {{ number_format($product->price, 2, ',', '.') }}</p>
                                <div class="mt-4">
                                    <button class="w-full bg-green-500 text-white py-2 rounded-md font-semibold transition hover:bg-green-600">
                                        Tambah ke Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 sm:col-span-2 lg:col-span-4 text-center text-gray-500 dark:text-gray-400">
                            <p>Saat ini belum ada produk yang dijual. Silakan cek kembali nanti!</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 dark:bg-gray-900 mt-16">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-300 dark:text-gray-400 text-sm">
                &copy; {{ date('Y') }} VAK Marketplace. All Rights Reserved.
            </p>
        </div>
    </footer>

</body>
</html>
