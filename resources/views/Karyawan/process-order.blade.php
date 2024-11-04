<x-karyawan-layout :title="$title">
    <x-karyawan-aside :outlet="$outlet"></x-karyawan-aside>
    <!-- Main content -->
    <div id="main-content" class="w-full transition-all duration-300">
        <x-karyawan-nav></x-karyawan-nav>
        
        <div class="w-full mt-4 flex justify-between">
            <div class="md:w-80 w-full">
                <div class="flex items-center max-w-sm">
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Order..." required />
                    </div>
                </div>
            </div>
        </div>

        <div class="h-max w-full flex justify-center gap-2 md:w-full md:flex-row flex-col mt-4">
            <!-- Order List -->
            <div id="ordersList" class=" w-full grid grid-cols-1 md:grid-cols-3 gap-2">

                {{-- Order Card --}}
                @forelse ($orders as $order)
                    <!-- Delivery or Pickup Order Card -->
                    <div class="order-card bg-white rounded-lg shadow-md border border-gray-200 p-4 mb-4 relative">
                        <div class="order-item flex justify-between items-start">
                            <div class="flex gap-5 items-center">

                                <input type="hidden" value="{{ $order->id }}" id="OrderId">

                                <!-- Order Type Image -->
                                <div class="flex justify-start">
                                    @if ($order->metode == 'Delivery')
                                        <img src="{{ asset('assets/icon-delivery.png') }}" alt="Order Type" class="w-20 h-20 rounded-lg shadow-md object-fill">
                                    @else
                                        <img src="{{ asset('assets/icon-pickup.png') }}" alt="Order Type" class="w-20 h-20 rounded-lg shadow-md object-fill">
                                    @endif
                                </div>
                                
                                <!-- Order Information -->
                                <div class="order-item">
                                    <h1 id="nama_pemesan" class="text-base font-bold text-gray-800">{{ $order->nama_pemesan }}</h1>
                                    <p id="no_telp" class="text-gray-600 text-sm">{{ $order->no_telp }}</p>
                                    <p id="resi" class="text-gray-600 text-sm">{{ $order->resi }}</p>
                                    
                                    <!-- Order Type and Status -->
                                    <div class="flex flex-wrap mt-2">
                                        @if ($order->metode == 'Delivery')
                                            <span class="inline-block text-xs bg-green-200 text-green-700 px-2 py-1 rounded-lg font-semibold mr-2">
                                                {{ $order->metode }}
                                            </span>
                                        @else
                                            <span class="inline-block text-xs bg-yellow-200 text-yellow-700 px-2 py-1 rounded-lg font-semibold mr-2">
                                                {{ $order->metode }}
                                            </span>
                                        @endif

                                        <span class="inline-block text-xs bg-green-200 text-green-700 px-2 py-1 rounded-lg font-semibold mr-2">
                                            {{ $order->status }}
                                        </span>
                                        
                                    </div>

                                    <!-- Order Time -->
                                    <div class="flex items-center space-x-1 mt-2">
                                        <span class="text-xs text-gray-500">Order Time:</span>
                                        <span class="text-xs text-blue-600 font-medium">{{ $order->created_at->addHours(7)->format('h:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex flex-col space-y-1">
                                <button 
                                    data-modal-target="detail-order-modal{{ $order->id }}" 
                                    data-modal-toggle="detail-order-modal{{ $order->id }}" 
                                    data-id="{{ $order->id }}" 
                                    class="px-3 py-1 text-xs bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    View
                                </button>
                                <button onclick="Konfirmasi({{ $order->id }}, 'Finish')" class="px-3 py-1 text-xs bg-green-500 text-white rounded-md hover:bg-green-600">
                                    Finish
                                </button>

                                <!-- Detail Order Modal -->
                                <div id="detail-order-modal{{ $order->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <!-- Modal header -->
                                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                    Detail Order {{ $order->resi }}
                                                </h3>
                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="detail-order-modal{{ $order->id }}">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="w-full flex justify-center items-center md:p-5 space-y-2 " >
                                                <div class="w-full max-w-xl overflow-y-auto" style="max-height: 500px;">
                                                    <input type="hidden" id="metode" value="{{ $order->metode }}">

                                                    {{-- Data Pemesan --}}
                                                    <div class="w-full rounded-lg bg-white dark:bg-gray-800 shadow-lg py-4 px-5 mb-6 border border-gray-200 dark:border-gray-700">
                                                        <div class="mb-2">
                                                            <div class="flex justify-between items-center text-gray-700 dark:text-gray-300 font-sans font-normal">
                                                                <span class="text-sm font-bold">Nama Pemesan:</span>
                                                                <span class="text-sm tracking-wide">{{ $order->nama_pemesan }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-2">
                                                            <div class="flex justify-between items-center text-gray-700 dark:text-gray-300 font-sans font-normal">
                                                                <span class="text-sm font-bold">Nomor Telpon:</span>
                                                                <span class="text-sm tracking-wide">{{ $order->no_telp }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-2">
                                                            <div class="flex justify-between items-center text-gray-700 dark:text-gray-300 font-sans font-normal">
                                                                <span class="text-sm font-bold">Tanggal Order:</span>
                                                                <span class="text-sm tracking-wide">{{ $order->tanggal_order }}</span>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="flex justify-between items-center text-gray-700 dark:text-gray-300 font-sans font-normal">
                                                                <span class="text-sm font-bold">Status:</span>
                                                                <span class="text-sm tracking-wide font-semibold px-2 py-1 rounded-lg
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
                                                    <div class="w-full rounded-lg bg-white dark:bg-gray-800 shadow-lg py-3 px-4 mb-6 border border-gray-200 dark:border-gray-700">
                                                        @if ($order->metode === 'PickUp')
                                                            <div class="flex items-center justify-between text-gray-700 dark:text-gray-300 font-sans font-light">
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
                                                                <span class="text-base font-bold">Metode Order:</span>
                                                                <div class="flex items-center gap-2 ml-2 p-2 rounded-lg bg-green-50 transition-shadow duration-200 shadow-sm hover:shadow-md">
                                                                    <img src="{{ asset('assets/icon-delivery.png') }}" class="w-8 h-8 p-1 shadow-sm" alt="Delivery Icon">
                                                                    <span class="text-sm font-medium tracking-wide text-gray-800 dark:text-gray-100">Delivery</span>
                                                                </div>
                                                            </div>

                                                            <div id="map{{ $order->id }}" class="w-full h-72 rounded-lg z-0 mt-4"></div>

                                                            <div class="text-gray-700 dark:text-gray-300 font-sans font-light mb-4">
                                                                <!-- Hidden Inputs for Coordinates -->
                                                                <input type="hidden" id="latitude{{ $order->id }}" name="latitude" value="{{ $order->latitude }}">
                                                                <input type="hidden" id="longitude{{ $order->id }}" name="longitude" value="{{ $order->longitude }}">

                                                                <!-- Address Display -->
                                                                <div class="flex justify-between items-center mb-2">
                                                                    <span class="text-lg font-bold">Alamat:</span>
                                                                    <a href="https://www.google.com/maps/place/{{ $order->latitude }},{{ $order->longitude }}" target="_blank" class="text-blue-600 hover:underline">See on Map</a>
                                                                </div>
                                                                <span class="text-base tracking-wide block ml-2">{{ $order->alamat_tujuan }}</span>
                                                            </div>

                                                        @endif
                                                    </div>

                                                    {{-- Data Produk --}}
                                                    <div class="w-full rounded-lg bg-white dark:bg-gray-800 shadow-lg py-4 px-5 mb-6 border border-gray-200 dark:border-gray-700">
                                                        <h2 class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-4">Produk yang dipesan:</h2>
                                                        <table class="min-w-full table-auto divide-y divide-gray-200 dark:divide-gray-700">
                                                            <thead>
                                                                <tr class="bg-gray-100 text-sm dark:bg-gray-700">
                                                                    <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300 font-medium">Nama Produk</th>
                                                                    <th class="px-4 py-2 text-center text-gray-600 dark:text-gray-300 font-medium">Jumlah</th>
                                                                    <th class="px-4 py-2 text-right text-gray-600 dark:text-gray-300 font-medium">Harga</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="bg-white dark:bg-gray-800">
                                                                @forelse ($order->DetailOrder as $item)
                                                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 text-xm transition-colors duration-200">
                                                                        <td class="px-4 py-2 text-xm text-gray-700 dark:text-gray-300">{{ $item->Produk->nama_produk }}</td>
                                                                        <td class="px-4 py-2 text-xm text-center text-gray-700 dark:text-gray-300">{{ $item->jumlah_barang }}</td>
                                                                        <td class="px-4 py-2 text-xm text-right text-gray-700 dark:text-gray-300">{{ number_format($item->subtotal / $item->jumlah_barang, 0, ',', '.') }}</td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="3" class="text-center py-4 text-gray-500">Tidak ada produk</td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="flex items-center justify-end p-4 border-t border-gray-200 dark:border-gray-600 gap-2">
                                                <button id="finish-button" type="button" class="px-3 py-2 text-sm bg-green-500 text-white rounded-md hover:bg-green-600">
                                                    Finish
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center">Tidak ada order yang tersedia saat ini.</p>
                @endforelse

            </div>
        </div>
    </div>

    {{-- SWEAT ALERT SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    {{-- LEAFLET SCRIPT --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-geosearch@latest/dist/bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // MENAMPILKAN MAP
            const buttons = document.querySelectorAll('[data-modal-target^="detail-order-modal"]');

            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    const orderId = this.dataset.id; // Get the order ID from the button data
                    const latitude = document.getElementById(`latitude${orderId}`).value;
                    const longitude = document.getElementById(`longitude${orderId}`).value;
                    const mapElement = document.getElementById(`map${orderId}`);

                    if (latitude && longitude) {
                        const map = L.map(mapElement).setView([latitude, longitude], 17); // Set initial view to lat/long

                        // Set up the map tile layer
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 20,
                        }).addTo(map);

                        const marker = L.marker([latitude, longitude]).addTo(map);
                    }
                });
            });

            const finishOrder = document.getElementById('finish-button');
            const orderId = document.getElementById('OrderId').value;

            // Function to update order status
            function updateOrderStatus(status) {
                
                if (!orderId) {
                    alert('Order ID is not set.');
                    return;
                }

                // Show loading spinner
                Swal.fire({
                    title: 'Mohon tunggu...',
                    text: 'Kami akan memberi tahu pelanggan.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading(); // Display loading spinner
                    }
                });

                fetch(`/orders/${orderId}/update`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ status }),
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Order Berhasil',
                            text: 'Sesuaikan dengan metode order yang dipilih',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                        
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Order Gagal',
                            text: 'Status Tidak Berubah',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error saving transaction:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Order Gagal',
                        text: 'Orderan gagal diproses',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                });
            }

            // Function to show confirmation alert and then update status
            function showConfirmationDialog(status) {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: `Apakah pesanan sudah selesai dibuat?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, sudah!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateOrderStatus(status);
                    }
                });
            }

            // Event listeners for buttons
            finishOrder.addEventListener('click', () => showConfirmationDialog('Finish'));
        });

        // SEARCH ORDERAN
        document.getElementById('simple-search').addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const orders = document.querySelectorAll('#ordersList .order-card');

            orders.forEach(order => {
                // Retrieve the text content for searching
                const namaPemesan = order.querySelector('h1').textContent.toLowerCase(); // Selects the order name
                const noTelp = order.querySelector('p:nth-child(2)').textContent.toLowerCase(); // Selects the phone number
                const resi = order.querySelector('p:nth-child(3)').textContent.toLowerCase(); // Selects the resi number

                // Show or hide based on matching query
                if (namaPemesan.includes(query) || noTelp.includes(query) || resi.includes(query)) {
                    order.style.display = 'block'; // Show the order card
                } else {
                    order.style.display = 'none'; // Hide the order card
                }
            });
        });

        const orderId = document.getElementById('OrderId').value;
        function Konfirmasi(orderId, status) {
            Swal.fire({
                title: 'Konfirmasi',
                text: `Apakah pesanan sudah selesai dibuat?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, sudah!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateOrderStatus(orderId, status);
                }
            });
        }

        function updateOrderStatus(orderId, status) {
            // Show loading spinner
            Swal.fire({
                title: 'Mohon tunggu...',
                text: 'Kami akan memberi tahu pelanggan.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading(); // Display loading spinner
                }
            });

            fetch(`/orders/${orderId}/update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ status }),
            })
            .then(response => response.json())
            .then(data => {
                Swal.close();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Order Berhasil',
                        text: 'Sesuaikan dengan metode order yang dipilih',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload(); // Reload page to see the updated status
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Order Gagal',
                        text: 'Status Tidak Berubah',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error saving transaction:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Order Gagal',
                    text: 'Orderan gagal diproses',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            });
        }


    </script>
    

</x-karyawan-layout>