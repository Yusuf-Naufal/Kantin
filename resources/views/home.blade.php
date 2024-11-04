<x-layout :title="$title">
    <div style="max-width: 1300px;" class="w-full flex-col md:flex-wrap mt-14 p-5 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-lg">

        {{-- SEARCH PRODUK --}}
        <div class="w-full flex justify-end">
            <form class="relative w-full md:w-1/3 mb-4">
                <label for="produk-search" class="sr-only">Search</label>
                <input type="search" id="produk-search" class="w-full p-2 pl-10 text-sm border rounded-lg dark:bg-gray-700 focus:ring-blue-500" placeholder="Mau makan apa hari ini?" required>
                <button type="submit" class="absolute inset-y-0 right-0 bg-blue-700 px-4 py-2 text-white rounded-r-lg">Search</button>
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            </form>
        </div>

        {{-- NAVIGATION CARDS --}}
        <div class="flex gap-6 justify-center my-5">
            <!-- Card 1 -->
            <div class="w-52 ">
                <a href="{{ route('daftar-outelt') }}" class="cursor-pointer w-full items-center px-3 py-6 bg-gradient-to-br from-blue-100 to-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 flex flex-col transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                    <svg class="w-12 h-12 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M5 6h14c.55 0 1-.45 1-1s-.45-1-1-1H5c-.55 0-1 .45-1 1s.45 1 1 1m15.16 1.8c-.09-.46-.5-.8-.98-.8H4.82c-.48 0-.89.34-.98.8l-1 5c-.12.62.35 1.2.98 1.2H4v5c0 .55.45 1 1 1h8c.55 0 1-.45 1-1v-5h4v5c0 .55.45 1 1 1s1-.45 1-1v-5h.18c.63 0 1.1-.58.98-1.2zM12 18H6v-4h6z"/>
                    </svg>
                </a>
                <h5 class="mt-2 text-base text-center font-medium tracking-tight text-gray-900 dark:text-white">Daftar Outlet</h5>   
            </div>

            <!-- Card 2 -->
            <div class="w-52">
                <a href="{{ route('daftar-produk') }}" class="cursor-pointer w-full items-center px-3 py-6 bg-gradient-to-br from-green-100 to-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 flex flex-col transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                    <svg class="w-12 h-12 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M18.06 23h1.66c.84 0 1.53-.65 1.63-1.47L23 5.05h-5V1h-1.97v4.05h-4.97l.3 2.34c1.71.47 3.31 1.32 4.27 2.26c1.44 1.42 2.43 2.89 2.43 5.29zM1 22v-1h15.03v1c0 .54-.45 1-1.03 1H2c-.55 0-1-.46-1-1m15.03-7C16.03 7 1 7 1 15zM1 17h15v2H1z"/>
                    </svg>
                </a>
                <h5 class="mt-2 text-base text-center font-medium tracking-tight text-gray-900 dark:text-white">Daftar Produk</h5>
            </div>
        </div>

        {{-- PRODUK FAVORIT --}}
        <section class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Menu Favorit</h2>
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">Menu terlaris di outlet kami</p>
            <div class="flex gap-6 overflow-x-auto pb-4">
                @forelse ($favorits as $kategori => $produkKategori)
                    @foreach ($produkKategori as $favorit)
                        <a href="{{ route('order-produk', $favorit->Outlet->uid) }}" class="w-48 hover:scale-105 transform transition-transform duration-300 flex flex-col items-center bg-gray-50 border border-gray-300 rounded-lg shadow-lg dark:bg-gray-800">
                            <img src="{{ Storage::url('assets/' . $favorit->foto) }}" alt="{{ $favorit->nama_produk }}" class="w-full h-40 object-fill rounded-t-lg">
                            <div class="px-4 py-4 w-full">
                                <p class="text-sm text-gray-600 dark:text-gray-400 text-left mb-1">{{ $favorit->Outlet->nama_outlet ?? 'Kosong' }}</p>
                                <h1 class="w-32 text-lg font-semibold text-gray-800 dark:text-white truncate" title="{{ $favorit->nama_produk }}">{{ $favorit->nama_produk }}</h1>
                            </div>
                        </a>
                    @endforeach
                @empty
                    <p class="text-center text-gray-500">Belum ada produk favorit untuk ditampilkan.</p>
                @endforelse
            </div>
        </section>

        {{-- PRODUCT PROMO --}}
        @if ($promos->isNotEmpty())
            <section class="mb-8">
                <h2 class="text-lg font-bold">Menu Promo</h2>
                <p class="text-sm font-light mb-4">Menu yang sedang promo</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($promos as $promo)
                        <a  href="{{ route('order-produk', $promo->Outlet->uid) }}" class="relative flex gap-4 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md hover:scale-105 transition-transform duration-300">
                            <div class="absolute top-0 left-0 bg-orange-300 text-white px-2 py-1 text-xs rounded-br-lg">Promo</div>
                            <img src="{{ Storage::url('assets/' . $promo->foto) }}" alt="{{ $promo->nama_produk }}" class="w-24 h-28 rounded-md object-cover shadow-sm">
                            <div class="flex flex-col justify-between">
                                <h1 class="text-lg font-semibold text-gray-800 dark:text-white truncate" title="{{ $promo->nama_produk }}">{{ $promo->nama_produk }}</h1>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $promo->Outlet->nama_outlet }}</p>
                                <p class="text-sm font-bold text-green-600">Rp. {{ number_format($promo->harga_jual, 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-600 truncate mt-2">{{ \Illuminate\Support\Str::limit($promo->deskripsi, 30) }}</p> <!-- Added mt-2 for spacing -->
                            </div>
                        </a>

                    @empty
                        <p class="text-center text-gray-500">Belum ada produk promo untuk ditampilkan.</p>
                    @endforelse
                </div>
            </section>
        @endif

        {{-- PRODUK DISKON --}}
        @if ($diskons->isNotEmpty())
            <section>
                <h2 class="text-lg font-bold">Diskon Menarik</h2>
                <p class="text-sm font-light mb-4">Menu yang sedang diskon!</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($diskons as $diskon)
                        <a href="{{ route('order-produk', $diskon->Outlet->uid) }}" class="relative p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md hover:scale-105 transition-transform duration-300">
                            <div class="absolute top-0 left-0 bg-red-500 text-white px-2 py-1 text-xs rounded-br-lg">Diskon</div>
                            <div class="flex gap-4">
                                <img src="{{ Storage::url('assets/' . $diskon->foto) }}" alt="{{ $diskon->nama_produk }}" class="w-20 h-20 rounded-md">
                                <div class="mt-2">
                                    <h1 class="text-lg font-semibold">{{ $diskon->nama_produk }}</h1>
                                    <p class="text-xs text-gray-500 line-through">Rp. {{ number_format($diskon->harga_jual, 0, ',', '.') }}</p>
                                    <p class="text-base font-bold text-green-600">Rp. {{ number_format($diskon->harga_diskon, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="text-center text-gray-500">Belum ada produk diskon untuk ditampilkan.</p>
                    @endforelse
                </div>
            </section>
        @endif

    </div>
</x-layout>
