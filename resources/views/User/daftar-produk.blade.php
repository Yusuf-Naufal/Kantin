<x-layout :title="$title">
    <div  style="max-width: 1300px;" class="w-full flex-col md:flex-wrap mt-14 p-5 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-lg">

        {{-- SEARCH PRODUK --}}
        <div class="w-full flex justify-end mb-4">
            <form action="{{ route('search-produk') }}" method="POST" class="relative w-full md:w-1/2 lg:w-1/3">
                @csrf
                <label for="produk-search" class="sr-only">Search</label>
                <input type="search" name="search" id="produk-search" class="w-full p-3 pl-10 text-sm border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500" placeholder="Mau makan apa hari ini?" required>
                <button type="submit" class="absolute inset-y-0 right-0 bg-blue-600 hover:bg-blue-700 transition duration-200 px-4 py-2 text-white rounded-r-lg">Search</button>
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                    <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            </form>
        </div>

        <div id="product-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($produks as $produk)
                <a href="{{ route('order-produk', $produk->Outlet->uid) }}" class="p-4 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 transition duration-300 ease-in-out hover:shadow-lg">
                    <img src="{{ Storage::url('assets/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}" class="w-full h-40 object-fill rounded-lg mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $produk->nama_produk }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Dari: {{ $produk->outlet->nama_outlet }}</p> 
                    <p class="text-xs text-gray-500 dark:text-gray-300">Harga: Rp. {{ number_format($produk->harga_jual, 0, ',', '.') }}</p>
                </a>
            @empty
                <p class="text-center text-gray-500 col-span-1 md:col-span-2 lg:col-span-3">Tidak ada produk untuk ditampilkan.</p>
            @endforelse
        </div>

    </div>
</x-layout>
