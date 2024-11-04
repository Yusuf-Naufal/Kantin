<x-karyawan-layout :title="$title">
    <x-karyawan-aside :outlet="$outlet"></x-karyawan-aside>
    <!-- Main content -->
    <div id="main-content" class="w-full transition-all duration-300">
        <x-karyawan-nav></x-karyawan-nav>

        <div class="bg-white p-6 rounded-lg shadow-md mt-2">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Final Order</h1>
            <p class="text-lg text-gray-600">
                ⚠️ Jika status order <span class="font-semibold text-yellow-600">Finish</span>, harap diubah menjadi 
                <span class="font-semibold text-green-600">Completed</span> agar data tersimpan di database transaksi.
            </p>
        </div>


        <div class="w-full flex justify-between mt-2 gap-2 flex-col md:flex-row">
            <form method="GET" action="{{ route('final-order') }}" class="flex flex-col md:flex-row items-center w-full space-y-2 md:space-y-0 md:space-x-2">
                <!-- Filter per_page -->
                <select name="per_page" 
                        class="bg-white w-full md:w-auto border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 shadow-sm transition duration-150 ease-in-out" 
                        id="per_page" 
                        onchange="this.form.submit()">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>

                <div class="flex w-full gap-2">
                    <!-- Filter tanggal menggunakan Flatpickr untuk rentang tanggal -->
                    <input type="text" id="date-range" 
                        class="bg-white w-full md:w-auto border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 shadow-sm transition duration-150 ease-in-out" 
                        name="date_range" 
                        value="{{ request('date_range') }}" 
                        placeholder="Pilih Rentang Tanggal">
    
                    <!-- Tombol submit -->
                    <button type="submit" class="bg-blue-500 text-white rounded-lg px-4 py-2">
                        Filter
                    </button>
                </div>
            </form>


            <div class="md:w-auto">
                <div class="flex items-center max-w-sm mx-auto">
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <input type="text" id="simple-search" onkeyup="searchTable()" class="w-full md:w-auto bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Order..." required />
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden mt-4">
            <div class="overflow-x-auto">
                <table id="order-table" class="min-w-full bg-white">
                    <thead class="bg-gray-600 border-b">
                        <tr>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm text-white">Resi</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm text-white">Pemesan</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm text-white">No. Telepon</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm text-white">Tanggal</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm text-white">Status</th>
                            <th class="text-center py-3 px-4 uppercase font-semibold text-sm text-white">Total Barang</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm text-white">Total Belanja</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm text-white">Metode</th>
                        </tr>
                    </thead>
                    <tbody id="data-body" class="text-gray-700 text-sm">
                        @forelse ($orders as $order)
                            <tr class="border-b cursor-pointer {{ $order->status == 'Finish' ? 'bg-yellow-100 hover:bg-yellow-200' : 'hover:bg-gray-100' }}"
                                onclick='openModal(
                                    "{{ $order->id }}",
                                    "{{ $order->Outlet->nama_outlet }}",
                                    "{{ $order->Outlet->alamat }}",
                                    "{{ $order->Outlet->no_telp }}",
                                    "{{ $order->tanggal_order }}",
                                    "{{ $order->resi }}",
                                    "{{ $order->nama_pemesan }}",
                                    "{{ $order->metode }}",
                                    "{{ $order->no_telp }}",
                                    "{{ $order->total_barang }}",
                                    "{{ $order->total_belanja }}",
                                    "{{ $order->catatan ?? 'Tidak ada catatan' }}",
                                    @json($order->DetailOrder)
                                )'>
                                <td class="py-3 px-4">{{ $order->resi }}</td>
                                <td class="py-3 px-4">{{ $order->nama_pemesan }}</td>
                                <td class="py-3 px-4">{{ $order->no_telp }}</td>
                                <td class="py-3 px-4">{{ $order->tanggal_order }}</td>
                                <td class="py-3 px-4">{{ $order->status }}</td>
                                <td class="py-3 px-4 text-center">{{ $order->total_barang }}</td>
                                <td class="py-3 px-4">Rp. {{ number_format($order->total_belanja, 0, ',', '.') }}</td>
                                <td class="py-3 px-4">{{ $order->metode }}</td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td colspan="10" class="text-center py-4 font-bold">No Order found</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Structure -->
        <div id="orderModal" class="w-full fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="w-full max-w-3xl mx-auto p-6 bg-white shadow-lg rounded-lg relative" style="max-width: 700px;">
                <!-- Close Button -->
                <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Header Outlet Info -->
                <div class="text-center mb-6">
                    <h1 id="modal-outlet-name" class="text-2xl font-semibold"></h1>
                    <p id="modal-outlet-address" class="text-sm text-gray-500"></p>
                    <p id="modal-outlet-phone" class="text-sm text-gray-500"></p>
                </div>

                <!-- Divider with Title -->
                <div class="relative flex items-center justify-center mb-6">
                    <hr class="w-full border-t border-gray-200">
                    <span class="absolute px-3 bg-white text-gray-600">Struk Order</span>
                </div>

                <div class="modal-body mt-6 max-h-96 overflow-y-auto">
                    <!-- Order Details -->
                    <div class="mb-6">
                        <div class="flex justify-between text-sm mb-2">
                            <p class="font-medium" id="modal-date"></p>
                            <p class="font-medium" id="modal-resi"></p>
                        </div>
                        <p class="text-sm text-gray-600" id="modal-customer-name"></p>
                        <p class="text-sm text-gray-600" id="modal-metode"></p>
                        <p class="text-sm text-gray-600" id="modal-customer-telp"></p>
                    </div>

                    <!-- Dotted Divider -->
                    <hr class="border-t-2 border-dashed border-gray-400 my-4">

                    <!-- Order Items -->
                    <div class="overflow-y-auto px-5" style="max-height: 100px;">
                        <table class="w-full text-sm text-left rounded-lg text-gray-500 mb-4">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 p-2">
                                <tr>
                                    <th class="py-2">Produk</th>
                                    <th class="py-2">Jumlah</th>
                                    <th class="py-2 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="modal-order-items">
                                <!-- Order items will be dynamically inserted here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Dotted Divider -->
                    <hr class="border-t-2 border-dashed border-gray-400 my-4">

                    <!-- Total Summary -->
                    <div class="text-sm font-medium mb-4">
                        <div class="flex justify-between">
                            <p>Total Belanja:</p>
                            <p id="modal-subtotal"></p>
                        </div>
                        <div class="flex justify-between">
                            <p>Biaya Penanganan:</p>
                            <p id="modal-penanganan"></p>
                        </div>
                        <div class="flex justify-between text-lg font-semibold">
                            <p>Total:</p>
                            <p id="modal-total"></p>
                        </div>
                    </div>
                </div>

                <!-- Dotted Divider -->
                <hr class="border-t-2 border-dashed border-gray-400 my-4">

                <!-- Notes Section -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-lg font-semibold">Catatan</h2>
                        <p class="text-red-600 font-extralight text-xs">*Tunjukan struk ini untuk mengambil pesanan</p>
                    </div>
                    <p id="modal-notes" class="text-sm text-gray-600"></p>
                </div>

                <div class="flex justify-end space-x-4 mt-6">
                    <button id="completeButton" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Complete</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Pagination Links -->
    <div class="flex items-center justify-between mt-4 px-4">
        <div class="text-gray-700">
            Showing <span class="font-semibold">{{ $orders->firstItem() }}</span> to <span class="font-semibold">{{ $orders->lastItem() }}</span> of <span class="font-semibold">{{ $orders->total() }}</span> results
        </div>
        <div>
            {{ $orders->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <!-- Include Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Include Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        flatpickr("#date-range", {
            mode: "range",
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                // Optional: you can automatically submit the form when a date range is selected
                // instance.element.form.submit();
            }
        });

        function openModal(id, outletName, outletAddress, outletPhone, date, resi, customerName, metode, customerTelp, totalQty, subtotal, notes, orderItems) {
            // Set modal content
            document.getElementById('modal-outlet-name').textContent = outletName;
            document.getElementById('modal-outlet-address').textContent = outletAddress;
            document.getElementById('modal-outlet-phone').textContent = outletPhone;
            document.getElementById('modal-date').textContent = `Tanggal: ${date}`;
            document.getElementById('modal-resi').textContent = `Resi: ${resi}`;
            document.getElementById('modal-customer-name').textContent = `Pemesan: ${customerName}`;
            document.getElementById('modal-metode').textContent = `Metode: ${metode}`;
            document.getElementById('modal-customer-telp').textContent = `No. Telepon: ${customerTelp}`;
            document.getElementById('modal-subtotal').textContent = `Rp. ${subtotal}`;

            let handlingFee;
            if (metode === 'Delivery') {
                handlingFee = 5000;
                document.getElementById('modal-penanganan').textContent = `Rp. 5.000`;
            } else {
                handlingFee = 2000;
                document.getElementById('modal-penanganan').textContent = `Rp. 2.000`;
            }

            const finalTotal = parseInt(subtotal) + handlingFee;
            document.getElementById('modal-total').textContent = `Rp. ${finalTotal.toLocaleString('id-ID')}`;

            document.getElementById('modal-notes').textContent = notes;

            // Populate order items
            const orderItemsTable = document.getElementById('modal-order-items');
            orderItemsTable.innerHTML = ''; // Clear existing items
            orderItems.forEach(item => {
                const row = document.createElement('tr');
                row.className = 'border-b border-gray-200';
                row.innerHTML = `
                    <td class="py-2">${item.produk.nama_produk}</td>
                    <td class="py-2">${item.jumlah_barang}</td>
                    <td class="py-2 text-right">Rp. ${item.subtotal}</td>
                `;
                orderItemsTable.appendChild(row);
            });

            // Set the global orderId
            window.currentOrderId = id;

            // Show the modal
            document.getElementById('orderModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('orderModal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const completeButton = document.getElementById('completeButton');

            // Function to update order status
            function updateOrderStatus(status) {
                if (!window.currentOrderId) {
                    alert('Order ID is not set.');
                    return;
                }

                fetch(`/orders/${window.currentOrderId}/update`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ status }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Order Berhasil',
                            text: 'Order Akan Diproses',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            closeModal(); // Close modal if needed
                            location.reload();
                        });
                        
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Order Gagal',
                            text: 'Status Tidak Berubah',
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
                        confirmButtonText: 'OK'
                    });
                });
            }

            // Function to show confirmation alert and then update status
            function showConfirmationDialog(status) {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: `Apakah uang sudah diterima anda?`,
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
            completeButton.addEventListener('click', () => showConfirmationDialog('Completed'));
        });

        function searchTable() {
            // Get the search input value
            const input = document.getElementById('simple-search');
            const filter = input.value.toLowerCase();

            // Get the table and tbody elements
            const table = document.getElementById('order-table');
            const tbody = table.getElementsByTagName('tbody')[0];
            const rows = tbody.getElementsByTagName('tr');

            let found = false;

            // Loop through all table rows and hide those that don't match the search input
            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                let matched = false;

                // Loop through all cells in the current row
                for (let j = 0; j < cells.length; j++) {
                    const cell = cells[j];
                    if (cell.textContent.toLowerCase().includes(filter)) {
                        matched = true;
                        break;
                    }
                }

                // Show or hide the row based on whether it matched
                rows[i].style.display = matched ? '' : 'none';

                // If a match is found, set the flag to true
                if (matched) {
                    found = true;
                }
            }

            // Remove any existing "No users found" row before adding a new one
            const noResultRow = document.getElementById('no-result-row');
            if (noResultRow) {
                noResultRow.remove();
            }

            // Check if no rows are visible, and if so, add a "No users found" row
            if (!found) {
                const noResultRow = document.createElement('tr');
                noResultRow.id = 'no-result-row';
                noResultRow.className = 'bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600';
                noResultRow.innerHTML = `
                    <td colspan="10" class="text-center py-4 font-bold">No users found</td>
                `;
                tbody.appendChild(noResultRow);
            }
        }
    </script>

</x-karyawan-layout>