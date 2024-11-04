<x-layout :title="$title">

    <style>
        .btn-transition {
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-hover {
            transform: scale(1.05); 
            background-color: #38a169;
        }
    </style>

    <div style="max-width: 680px;" class="mx-auto w-full flex justify-center items-center flex-col py-6 px-3 mt-14 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg">
        <div data-aos="zoom-in" class="w-full flex items-center justify-center mb-6 relative">
            <img class="w-full h-auto max-w-xl" src="{{ asset('assets/waiting-order.png') }}" alt="Waiting for Order">
            

            
                @if ($order->status == 'Pending')
                    <!-- Pending: Countdown and Cancel Option -->
                    <button id="countdownButton" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 rounded-full bg-red-600 text-white font-medium flex items-center justify-between px-4 sm:px-6 py-2 sm:py-3 w-40 sm:w-44 transition-all duration-300 shadow-lg hover:bg-red-700 focus:ring-2 focus:ring-offset-2 focus:ring-red-500 focus:outline-none">
                        <span class="text-xs sm:text-sm">Cancel in:</span>
                        <span id="countdown-timer" class="text-xs sm:text-sm ml-2">01:00</span>
                    </button>
                @elseif ($order->status == "Cancelled")  
                    <!-- Cancelled: Display Canceled State -->
                    <button class="absolute bottom-4 left-1/2 transform -translate-x-1/2 rounded-full bg-gray-500 text-white font-medium flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 w-40 sm:w-44 transition-all duration-300 shadow-lg cursor-not-allowed">
                        <span class="text-xs sm:text-sm">Cancelled</span>
                    </button>
                @elseif ($order->status == "Waiting")
                    <!-- Processed (Waiting): Display Processing State -->
                    <button class="absolute bottom-4 left-1/2 transform -translate-x-1/2 rounded-full bg-yellow-300 text-white font-medium flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 w-40 sm:w-44 transition-all duration-300 shadow-lg hover:bg-yellow-500 focus:ring-2 focus:ring-offset-2 focus:ring-yellow-700 focus:outline-none">
                        <span class="text-xs sm:text-sm">Waiting</span>
                    </button>
                @elseif ($order->status == "Process")
                    <!-- Processed (Process): Display Processing State -->
                    <button class="absolute bottom-4 left-1/2 transform -translate-x-1/2 rounded-full bg-green-600 text-white font-medium flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 w-40 sm:w-44 transition-all duration-300 shadow-lg hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 focus:outline-none">
                        <span class="text-xs sm:text-sm">Process</span>
                    </button>
                @elseif ($order->status == "Rejected")
                    <!-- Processed (Rejected): Display Processing State -->
                    <button class="absolute bottom-4 left-1/2 transform -translate-x-1/2 rounded-full bg-red-600 text-white font-medium flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 w-40 sm:w-44 transition-all duration-300 shadow-lg hover:bg-red-700 focus:ring-2 focus:ring-offset-2 focus:ring-red-500 focus:outline-none">
                        <span class="text-xs sm:text-sm">Rejected</span>
                    </button>
                @else
                    <!-- Processed (Completed): Display Processing State -->
                    <button class="absolute bottom-4 left-1/2 transform -translate-x-1/2 rounded-full bg-green-600 text-white font-medium flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 w-40 sm:w-44 transition-all duration-300 shadow-lg hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 focus:outline-none">
                        <span class="text-xs sm:text-sm">Completed</span>
                    </button>
                @endif
           

        </div>

        <!-- Order Receipt Number -->
        <div data-aos="zoom-in" class="w-full flex justify-center rounded-lg bg-white dark:bg-gray-800 shadow-lg py-4 px-5 max-w-xl mb-6 border border-gray-200 dark:border-gray-700">
            <div class="w-full flex justify-between items-center text-gray-700 dark:text-gray-300 font-sans font-light">
                <span class="text-base font-bold">Nomor Resi :</span>
                <span class="text-base tracking-wide">{{ $order->resi }}</span>
                <input type="hidden" id="OrderId" value="{{ $order->id }}"></input>
            </div>
        </div>

        <!-- Customer Information -->
        <div data-aos="zoom-in" class="w-full rounded-lg bg-white dark:bg-gray-800 shadow-lg py-4 px-5 max-w-xl mb-6 border border-gray-200 dark:border-gray-700">
            <div class="mb-2">
                <div class="flex justify-between items-center text-gray-700 dark:text-gray-300 font-sans font-light">
                    <span class="text-base font-bold">Nama Pemesan:</span>
                    <span class="text-base tracking-wide">{{ $order->nama_pemesan }}</span>
                </div>
            </div>
            <div class="mb-2">
                <div class="flex justify-between items-center text-gray-700 dark:text-gray-300 font-sans font-light">
                    <span class="text-base font-bold">Nomor Telpon:</span>
                    <span class="text-base tracking-wide">{{ $order->no_telp }}</span>
                </div>
            </div>
            <div class="mb-2">
                <div class="flex justify-between items-center text-gray-700 dark:text-gray-300 font-sans font-light">
                    <span class="text-base font-bold">Tanggal Order:</span>
                    <span class="text-base tracking-wide">{{ $order->tanggal_order }}</span>
                </div>
            </div>
            <div>
                <div class="flex justify-between items-center text-gray-700 dark:text-gray-300 font-sans font-light">
                    <span class="text-base font-bold">Status:</span>
                    <span class="text-base tracking-wide font-semibold px-2 py-1 rounded-lg
                        {{ $order->status == 'Pending' ? 'bg-yellow-100 text-yellow-600' : '' }}
                        {{ $order->status == 'Process' ? 'bg-green-100 text-green-600' : '' }}
                        {{ $order->status == 'Waiting' ? 'bg-yellow-100 text-yellow-600' : '' }}
                        {{ $order->status == 'Cancelled' ? 'bg-gray-100 text-gray-600' : '' }}
                        {{ $order->status == 'Completed' ? 'bg-green-100 text-green-600' : '' }}
                        {{ $order->status == 'Rejected' ? 'bg-red-100 text-red-600' : '' }}">
                        {{ $order->status }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Order Method -->
        <div data-aos="zoom-in" class="w-full rounded-lg bg-white dark:bg-gray-800 shadow-lg py-3 px-4 max-w-xl mb-6 border border-gray-200 dark:border-gray-700">
            @if ($order->metode === 'PickUp')
                <div class="flex items-center justify-between text-gray-700 dark:text-gray-300 font-sans font-light">
                    <!-- Label -->
                    <span class="text-base font-bold">Metode Order:</span>
                    
                    <div class="flex items-center gap-2 ml-2 p-2 rounded-lg bg-green-50 transition-shadow duration-200 shadow-sm hover:shadow-md">
                        <img src="{{ asset('assets/icon-pickup.png') }}" class="w-8 h-8 p-1 shadow-sm" alt="PickUp Icon">
                        <span class="text-sm font-medium tracking-wide text-gray-800 dark:text-gray-100">Pick Up</span>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between items-center text-gray-700 dark:text-gray-300 font-sans font-light">
                        <span class="text-base font-bold">Jam Ambil:</span>
                        <span class="text-base tracking-wide">{{ $order->jam_ambil }}</span>
                    </div>
                </div>
            @else
                <div class="flex items-center justify-between text-gray-700 dark:text-gray-300 font-sans font-light">
                    <!-- Label -->
                    <span class="text-base font-bold">Metode Order:</span>
                    
                    <div class="flex items-center gap-2 ml-2 p-2 rounded-lg bg-green-50 transition-shadow duration-200 shadow-sm hover:shadow-md">
                        <img src="{{ asset('assets/icon-delivery.png') }}" class="w-8 h-8 p-1 shadow-sm" alt="PickUp Icon">
                        <span class="text-sm font-medium tracking-wide text-gray-800 dark:text-gray-100">Delivery</span>
                    </div>
                </div>
                <div id="map" class="w-full h-72 rounded-lg z-0"></div>
                <div>
                    <!-- Address Display -->
                    <div class="text-gray-700 dark:text-gray-300 font-sans font-light mb-4">
                        <input type="hidden" id="latitude" name="latitude" value="{{ $order->latitude }}">
                        <input type="hidden" id="longitude" name="longitude" value="{{ $order->longitude }}">
                        <span class="text-lg font-bold">Alamat:</span>
                        <span class="text-base tracking-wide block ml-2">{{ $order->alamat_tujuan }}</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Produk yang dibeli -->
        <div data-aos="zoom-in" class="w-full rounded-lg bg-white dark:bg-gray-800 shadow-lg py-4 px-5 max-w-xl mb-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Produk yang dipesan:</h2>
            <table class="min-w-full table-auto divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300 font-medium">Nama Produk</th>
                        <th class="px-4 py-2 text-center text-gray-600 dark:text-gray-300 font-medium">Jumlah</th>
                        <th class="px-4 py-2 text-right text-gray-600 dark:text-gray-300 font-medium">Harga</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800">
                    @forelse ($detailOrder as $item)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-4 py-2 text-gray-700 dark:text-gray-300">{{ $item->Produk->nama_produk }}</td>
                            <td class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">{{ $item->jumlah_barang }}</td>
                            <td class="px-4 py-2 text-right text-gray-700 dark:text-gray-300">{{ $item->subtotal }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-500 dark:text-gray-400 py-2">Tidak ada produk yang dipesan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>



        <!-- Payment Details -->
        @php
            $total_penanganan = $order->metode === 'PickUp' ? 2000 : 5000;
            $grand_total = $order->total_belanja + $total_penanganan;
        @endphp

        <div data-aos="zoom-in" class="w-full max-w-xl rounded-lg bg-white dark:bg-gray-800 shadow-lg py-4 px-5 mb-6 border border-gray-200 dark:border-gray-700 transition-all duration-200">
            <!-- Header with Title and Payment Method -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Detail Pembayaran</h2>
                <div class="flex items-center gap-3 p-2 bg-green-50 dark:bg-green-700 rounded-lg shadow hover:shadow-md transition-shadow duration-200">
                    <svg class="w-8 h-8 p-1" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 36 36"><path fill="#5c913b" d="M35.602 16.28c-2.582-3.761-7.92 1.774-17.662 2.899c-3.607.416-6.857 3.428-11.047 3.141c-1.718-.118-4.117-5.061-5.913-4.273c-.924.406-1.348 1.761-.398 2.779L11.13 33.412s.536.618 2.342.19c.445.131 7.135-2.55 11.003-7.917c.926-1.285 2.03-2.355 3.173-3.249c3.711-2.744 7.745-3.7 7.745-3.7c.516-.426.637-.879.609-1.272c.034-.656-.4-1.184-.4-1.184"/><path fill="#a7d28b" d="M11.476 10.274c-3.783 5.25-10.408 7.737-10.408 7.737c-1.236 1.047-.192 2.281-.192 2.281l10.438 12.359s.522.617 2.28.189c0 0 6.625-2.482 10.407-7.732c3.899-5.41 10.93-7.118 10.93-7.118c1.235-1.047.192-2.283.192-2.283L24.685 3.35s-.522-.618-2.28-.192c0 0-7.03 1.704-10.929 7.116"/><circle cx="22" cy="14" r="5.5" fill="#77b255"/><path fill="#5c913b" d="M12.873 31.929c-.881 0-1.204-.328-1.248-.378L2.216 20.568c-.018-.021-.495-.567-.437-1.261c.035-.421.253-.796.647-1.115l.063-.038c.061-.024 6.163-2.532 9.583-7.065l.2.15l-.2-.15c3.618-4.796 9.859-6.854 9.921-6.874c1.745-.406 2.316.174 2.377.242l9.285 11.044c.017.018.493.566.435 1.261c-.035.42-.253.795-.647 1.114l-.099.049c-.061.015-6.129 1.523-9.644 6.181c-3.499 4.64-9.607 7.642-9.668 7.671c-.464.11-.846.152-1.159.152m-.871-.707c.001 0 .452.416 1.865.088c.008-.011 6.009-2.962 9.436-7.504c3.437-4.555 9.225-6.182 9.867-6.351q.386-.333.422-.729c.042-.48-.312-.893-.315-.897L23.992 4.784c-.002 0-.45-.415-1.864-.087c-.041.014-6.135 2.026-9.656 6.693c-3.366 4.461-9.239 6.995-9.758 7.213q-.402.34-.437.745c-.04.476.312.887.315.891z"/><path fill="#ffac33" d="m21.276 22.166l-.006 5.94l.497.59c.969-.884 1.9-1.878 2.705-2.996a15.8 15.8 0 0 1 2.828-2.986l-.483-.575z"/><path fill="#ffe8b6" d="M26.798 22.118L14.292 7.305c-1.016.836-1.992 1.811-2.822 2.964c-.811 1.126-1.755 2.117-2.735 2.991l1.462 1.731l-.001.001l11.075 13.114a18.7 18.7 0 0 0 2.725-3.003c.83-1.152 1.805-2.126 2.82-2.962z"/><path fill="#5c913b" d="M14.479 22.555c-1.557-1.844-4.853 1.148-5.793.035c-.455-.539-.162-1.238.436-1.742c1.005-.85 1.73-.355 2.185-.74c.323-.272.306-.605.114-.834c-.446-.527-1.586-.252-2.472.26l-.431-.51a.754.754 0 0 0-1.152.972l.446.529c-.677.898-.907 2.09-.106 3.037c1.496 1.77 4.833-1.172 5.883.072c.364.432.262 1.256-.504 1.902c-1.148.971-2.188.516-2.655.91c-.228.191-.269.555-.026.844c.387.457 1.62.359 2.805-.379l.002.006l.487.576a.755.755 0 1 0 1.153-.974l-.487-.576l-.019-.016c.799-.978 1.069-2.267.134-3.372"/><path fill="#e1e8ed" d="m32.456 32.588l.028-.021c.068-.068.121-.146.181-.221c.042-.052.089-.102.128-.155c.035-.05.064-.101.096-.152c1.42-2.187.49-5.895-2.321-8.707s-6.521-3.742-8.707-2.321c-.052.031-.103.06-.153.096c-.053.039-.104.086-.154.127c-.074.061-.152.113-.221.182q-.013.014-.022.028c-.011.011-.024.018-.036.03l.006.005c-1 1.062-1.012 2.705-.006 3.712c1.008 1.008 2.65.994 3.713-.006l.011.012c-.021.02-.044.033-.064.053c-1.059 1.059-1.084 2.748-.059 3.775c1.026 1.025 2.717 1 3.775-.059c.02-.02.033-.043.053-.064l.011.012c-1 1.062-1.013 2.705-.005 3.713c1.007 1.006 2.649.994 3.711-.006l.006.006q.014-.021.029-.039"/><path fill="#ccd6dd" d="M21.277 25.231c.906.905 2.321.979 3.37.261c.439-.75.565-1.463.565-1.686c-2.207 1.646-4.177.009-4.618-.97c-.183.846.039 1.75.683 2.395m7.299 3.84c.298-.419.529-.824.637-1.098c-1.405 1.288-4.091.345-4.905-1.698c-.358.95-.175 2.044.571 2.79c1.002 1.002 2.634.994 3.697.006m3.854 3.595l.029-.036q.016-.011.028-.022c.069-.068.122-.146.181-.22c.043-.053.089-.102.128-.156c.036-.049.065-.101.097-.152c.065-.1.1-.218.155-.324c-2.528 1.131-4.415-.788-4.944-1.745c-.295.917-.103 1.944.609 2.657c1.006 1.007 2.648.995 3.711-.006z"/><path fill="#e1e8ed" d="m13.956 12.498l.028-.022c.069-.068.122-.146.181-.22c.042-.052.088-.101.127-.155c.036-.05.065-.101.097-.152c1.42-2.187.489-5.896-2.322-8.707S5.547-.501 3.36.919c-.051.032-.103.061-.153.097c-.054.039-.103.085-.155.127c-.074.06-.152.112-.22.181l-.022.028l-.036.03l.005.005c-1 1.062-1.012 2.705-.005 3.712s2.65.995 3.712-.005l.011.011c-.021.019-.044.033-.064.053c-1.059 1.059-1.084 2.748-.058 3.775s2.716 1.001 3.775-.058c.02-.02.033-.043.053-.064l.011.011c-1 1.062-1.013 2.705-.005 3.712c1.007 1.007 2.649.995 3.711-.006l.005.006z"/><path fill="#ccd6dd" d="M2.773 5.1c.906.906 2.321.98 3.37.26c.439-.75.564-1.462.564-1.685c-2.206 1.645-4.177.007-4.617-.972c-.183.847.039 1.752.683 2.397m7.301 3.838c.297-.419.528-.822.635-1.096c-1.406 1.288-4.092.344-4.905-1.699c-.358.95-.175 2.044.57 2.79c1.004 1.003 2.637.994 3.7.005m3.851 3.597q.016-.017.03-.036l.028-.022c.069-.068.122-.146.181-.22c.042-.052.088-.101.127-.155c.036-.05.065-.101.097-.152c.065-.1.1-.219.155-.325c-2.528 1.131-4.415-.787-4.944-1.744c-.295.917-.103 1.944.609 2.656c1.007 1.007 2.649.995 3.711-.006z"/></svg>
                    <span class="text-sm font-medium text-green-800 dark:text-green-100">Tunai</span>
                </div>
            </div>
            
            <!-- Total Belanja -->
            <div class="flex justify-between items-center py-2 text-gray-700 dark:text-gray-300">
                <span class="text-lg font-light">Total Belanja:</span>
                <span class="text-lg font-medium tracking-wide">{{ number_format($order->total_belanja, 0, ',', '.') ?? 'Rp 0' }}</span>
            </div>
            
            <!-- Total Penanganan -->
            <div class="flex justify-between items-center py-2 border-t border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300">
                <span class="text-lg font-light">Biaya Penanganan:</span>
                <span class="text-lg font-medium tracking-wide">{{ number_format($total_penanganan, 0, ',', '.') }}</span>
            </div>

            <!-- Grand Total -->
            <div class="flex justify-between items-center py-3 border-t border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100">
                <span class="text-lg font-bold">Total:</span>
                <span class="text-lg font-semibold tracking-wide text-green-700 dark:text-green-400">Rp {{ number_format($grand_total, 0, ',', '.') }}</span>
            </div>
        </div>

        <input type="hidden" value="{{ $order->metode }}" id="metode">
        <input type="hidden" value="{{ $order->status }}" id="status">

    </div>


    {{-- AOS SCRIPT --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    {{-- SWEAT ALERT SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    {{-- LEAFLET SCRIPT --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-geosearch@latest/dist/bundle.min.js"></script>

    <script>
        AOS.init();

        const metode = document.getElementById('metode').value;
            if (metode === "Delivery") {
                const provider = new GeoSearch.OpenStreetMapProvider();
                const latitude = parseFloat(document.getElementById('latitude').value.trim());
                const longitude = parseFloat(document.getElementById('longitude').value.trim());

                // Display Map
                const map = L.map('map').setView([latitude, longitude], 17);

                L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
                    maxZoom: 20,
                }).addTo(map);

                L.marker([latitude, longitude]).addTo(map)
                    .bindPopup('Lokasi Tujuan!')
                    .openPopup();

                const search = new GeoSearch.GeoSearchControl({
                    provider: new GeoSearch.OpenStreetMapProvider(),
                    style: 'button',
                });

                map.addControl(search);
            }

        // MEMBATALKAN PESANAN
        let timeLeft = 60; 
        const countdownDisplay = document.getElementById("countdown-timer");
        const countdownButton = document.getElementById("countdownButton");
        const orderId = document.getElementById('OrderId').value;

        // Timer
        function updateDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            countdownDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        // Ubah Status
        async function updateOrderStatus(orderId, status) {
            try {
                const response = await fetch(`/orders/${orderId}/update`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Include CSRF token for Laravel
                    },
                    body: JSON.stringify({ status: status })
                });

                const data = await response.json();
                if (data.success) {
                    console.log("Order status updated to", status);
                    location.reload();
                } else {
                    console.error("Failed to update status:", data.message);
                }
            } catch (error) {
                console.error("Error:", error);
            }
        }


        const status = document.getElementById('status').value;
        if (status === "Pending") {
            // Hitung Mundur Waktu
            const countdownInterval = setInterval(function() {
                if (timeLeft > 0) {
                    timeLeft--;
                    updateDisplay();
                } else {
                    clearInterval(countdownInterval);
                    countdownButton.classList.remove("bg-red-600", "justify-between");
                    countdownButton.classList.add("bg-green-500", "hover:bg-green-600", "btn-transition", "btn-active", "flex", "justify-center", "text-center");
                    countdownButton.textContent = "Order Diproses";
                    countdownDisplay.classList.add("hidden");

                    updateOrderStatus(orderId, 'Waiting');

                    setTimeout(() => {
                        countdownButton.classList.remove("btn-active");
                    }, 600);
                }
            }, 1000);

            // Button Cancel
            document.getElementById("countdownButton").addEventListener("click", function () {
                if (timeLeft > 0) {
                    Swal.fire({
                        title: 'Are you sure you want to cancel?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, cancel it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Change button appearance and disable it
                            countdownButton.classList.remove("bg-red-600", "justify-between");
                            countdownButton.classList.add("bg-gray-500", "cursor-not-allowed", "justify-center", "text-center");
                            countdownButton.textContent = "Cancelled";
                            countdownButton.setAttribute("disabled", true); // Disable button
                            clearInterval(countdownInterval); // Stop the countdown

                            updateOrderStatus(orderId, 'Cancelled');
                        }
                    });
                }
            });

            updateDisplay();
        }
    </script>
</x-layout>