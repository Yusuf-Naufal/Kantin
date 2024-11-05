<x-layout :title="$title">
    <div class="max-w-5xl mx-auto p-6 mt-14 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-lg">

        {{-- SEARCH OUTLET --}}
        <div class="w-full flex justify-end mb-4">
            <form class="relative w-full md:w-1/3">
                <label for="outlet-search" class="sr-only">Search</label>
                <input type="search" id="outlet-search" class="w-full p-2 pl-10 text-sm border rounded-lg dark:bg-gray-700 focus:ring-blue-500" placeholder="Search Outlet..." oninput="filterOutlets()" required>
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            </form>
        </div>

        <h2 class="text-3xl font-bold mb-6 text-center text-gray-800 dark:text-white">Daftar Outlet</h2>
        
        <div id="outlet-list">
            @forelse($outlets as $outlet)
                <div class="mb-8 p-6 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 transition duration-300 ease-in-out hover:shadow-lg outlet-item" data-name="{{ strtolower($outlet->nama_outlet) }}">
                    <div class="flex flex-col justify-start md:flex-row md:justify-between items-start mb-4">
                        <div class="flex gap-4 items-start justify-start flex-col md:flex-row">
                            {{-- Gambar Outlet --}}
                            <div class="flex-shrink-0">
                                <img src="{{ Storage::url('app/public/assets/' . $outlet->foto) }}" alt="{{ $outlet->nama_outlet }}" class="w-max md:w-24 h-24 rounded-lg object-cover border border-gray-200 dark:border-gray-600">
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-white">{{ $outlet->nama_outlet }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $outlet->alamat }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-300">Jam Operasional: {{ \Carbon\Carbon::createFromFormat('H:i:s', $outlet->jam_buka)->format('H:i') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $outlet->jam_tutup)->format('H:i') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-300">Telp: {{ $outlet->no_telp }}</p>
                            </div>
                        </div>

                        {{-- Button Mengarah ke Order --}}
                        <div class="mt-4 md:mt-0">
                            <a href="{{ route('order-produk', $outlet->uid) }}" class="bg-blue-500 text-white rounded-lg px-4 py-2 text-sm hover:bg-blue-600 transition">Pesan Sekarang</a>
                        </div>
                    </div>

                    <h4 class="font-bold text-gray-800 dark:text-white mb-2">Produk Tersedia:</h4>
                    <section>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                            @forelse($outlet->Produk as $produk)
                                <div class="bg-white dark:bg-gray-800 border border-gray-200 rounded-lg shadow-md transition-transform duration-300 ease-in-out transform hover:scale-105">
                                    <img src="{{ Storage::url('app/public/assets/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}" class="w-full h-32 object-cover rounded-t-lg">
                                    <div class="p-2">
                                        <h5 class="text-sm font-semibold text-gray-800 dark:text-white truncate mt-2">{{ $produk->nama_produk }}</h5>
                                        <p class="text-xs text-gray-500 dark:text-gray-300">Harga: Rp. {{ number_format($produk->harga_jual, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center col-span-4">Tidak ada produk tersedia.</p>   
                            @endforelse
                        </div>
                    </section>
                </div> 
            @empty
                <p class="text-center text-gray-500">Belum ada outlet untuk ditampilkan.</p>
            @endforelse
        </div>
    </div>

    <script>
        function filterOutlets() {
            const searchInput = document.getElementById('outlet-search').value.toLowerCase();
            const outletItems = document.querySelectorAll('.outlet-item');

            outletItems.forEach(item => {
                const outletName = item.getAttribute('data-name');
                if (outletName.includes(searchInput)) {
                    item.style.display = ''; // Show the outlet
                } else {
                    item.style.display = 'none'; // Hide the outlet
                }
            });
        }
    </script>
</x-layout>
