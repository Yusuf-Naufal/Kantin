@props(['outlet'])

<!-- Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 w-64 h-screen bg-gray-800 text-white z-40 lg:relative lg:translate-x-0 lg:w-64 lg:overflow-y-auto transition-transform transform -translate-x-full">
    <div class="px-4 py-4 flex items-center justify-between border-b border-gray-700">
        <div class="flex gap-3 items-center">
            <img src="{{ Storage::url('app/public/assets/' . $outlet->foto) }}" alt="Logo" class="h-12 w-12 rounded-full object-cover">
            <div>
                <p class="text-base font-semibold truncate">{{ $outlet->nama_outlet }}</p>
                <p class="text-sm text-gray-400">{{ $outlet->pemilik }}</p>
            </div>
            <button type="button" id="close-sidebar" class="text-gray-400 mt-1 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm p-2.5 absolute top-2.5 right-2.5 flex items-center justify-center">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Close menu</span>
            </button>
        </div>
    </div>
    <ul class="space-y-2 px-4 mt-4">
        <!-- POS Link -->
        <li>
            <a href="{{ route('kasir-dashboard') }}" class="flex items-center p-3 text-gray-200 hover:bg-gray-700 rounded-md transition duration-200 group">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-basket flex-shrink-0" viewBox="0 0 16 16">
                    <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9zM1 7v1h14V7zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5"/>
                </svg>
                <span class="text-lg font-medium ms-3">POS</span>
            </a>
        </li>

        <!-- Stok Link -->
        <li>
            <a href="{{ route('stok-produk') }}" class="flex items-center p-3 text-gray-200 hover:bg-gray-700 rounded-md transition duration-200 group">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-archive-fill flex-shrink-0" viewBox="0 0 16 16">
                    <path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1M.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8z"/>
                </svg>
                <span class="text-lg font-medium ms-3">STOK</span>
            </a>
        </li>

        <!-- Order Link with Order Count -->
        <li>
            <a href="{{ route('list-order') }}" class="flex items-center justify-between p-3 text-gray-200 hover:bg-gray-700 rounded-md transition duration-200 group">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bookmark-plus flex-shrink-0" viewBox="0 0 16 16">
                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5V6H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V7H6a.5.5 0 0 1 0-1h1.5V4.5A.5.5 0 0 1 8 4"/>
                    </svg>
                    <span class="text-lg font-medium ms-3">Waiting Order</span>
                </div>
                <span id="order-count" class="bg-red-500 text-white text-xs font-semibold rounded-full px-2 py-0.5">0</span>
            </a>
        </li>

        <!-- Order Link with Order Count -->
        <li>
            <a href="{{ route('process-order') }}" class="flex items-center justify-between p-3 text-gray-200 hover:bg-gray-700 rounded-md transition duration-200 group">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="bi bi-bookmark-plus flex-shrink-0"  viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 22c-.818 0-1.6-.33-3.163-.99C3.946 19.366 2 18.543 2 17.16V7m9 15V11.355M11 22c.34 0 .646-.057 1-.172M20 7v4.5M18 18l.906-.905M22 18a4 4 0 1 0-8 0a4 4 0 0 0 8 0M7.326 9.691L4.405 8.278C2.802 7.502 2 7.114 2 6.5s.802-1.002 2.405-1.778l2.92-1.413C9.13 2.436 10.03 2 11 2s1.871.436 3.674 1.309l2.921 1.413C19.198 5.498 20 5.886 20 6.5s-.802 1.002-2.405 1.778l-2.92 1.413C12.87 10.564 11.97 11 11 11s-1.871-.436-3.674-1.309M5 12l2 1m9-9L6 9" color="currentColor"/></svg>
                    <span class="text-lg font-medium ms-3">Process Order</span>
                </div>
                <span id="process-count" class="bg-green-500 text-white text-xs font-semibold rounded-full px-2 py-0.5">0</span>
            </a>
        </li>

        <!-- Order Link with Order Count -->
        <li>
            <a href="{{ route('final-order') }}" class="flex items-center justify-between p-3 text-gray-200 hover:bg-gray-700 rounded-md transition duration-200 group">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="bi bi-bookmark-plus flex-shrink-0" viewBox="0 0 16 16"><path fill="currentColor" d="M1.5 8a6.5 6.5 0 1 1 13 0A.75.75 0 0 0 16 8a8 8 0 1 0-8 8a.75.75 0 0 0 0-1.5A6.5 6.5 0 0 1 1.5 8"/><path fill="currentColor" d="m8.677 12.427l2.896 2.896a.25.25 0 0 0 .427-.177V13h3.25a.75.75 0 0 0 0-1.5H12V9.354a.25.25 0 0 0-.427-.177l-2.896 2.896a.25.25 0 0 0 0 .354M11.28 6.78a.749.749 0 1 0-1.06-1.06L7.25 8.689L5.78 7.22a.749.749 0 1 0-1.06 1.06l2 2a.75.75 0 0 0 1.06 0z"/></svg>
                    <span class="text-lg font-medium ms-3">Final Order</span>
                </div>
                <span id="finish-count" class="bg-yellow-500 text-white text-xs font-semibold rounded-full px-2 py-0.5">0</span>
            </a>
        </li>


    </ul>
</aside>
