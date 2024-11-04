<x-master-layout :title="$title">
    
    <div class="w-full p-1">
        <h1 class="text-3xl font-bold mb-3">Laporan Outlet</h1>

       {{-- Monitoring Produk, Transaksi, Penghasilan, Keuntungan --}}
        <div class="w-full flex flex-col md:flex-row gap-2 mb-4">

            {{-- Jumlah Produk Outlet --}}
            <div class="rounded-lg w-full flex items-center p-3 gap-4 text-white shadow-md" style="background: #F0E68C ">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 56 56"><path fill="currentColor" d="m41.266 19.117l8.812-5.015c-.352-.352-.774-.633-1.289-.915l-16.523-9.42C30.813 2.946 29.406 2.5 28 2.5s-2.812.445-4.266 1.266L18.977 6.46ZM28 26.641l10.008-5.672l-22.195-12.68l-8.602 4.899c-.516.28-.937.562-1.29.914ZM29.594 53.5c.164-.047.304-.117.469-.21l18.351-10.454c2.18-1.242 3.375-2.508 3.375-5.906V18.672c0-.703-.07-1.266-.187-1.781L29.594 29.453Zm-3.188 0V29.453L4.4 16.891a7.8 7.8 0 0 0-.188 1.78V36.93c0 3.398 1.195 4.664 3.375 5.906l18.352 10.453c.164.094.304.164.468.211"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">Total Produk</h1>
                    <p class="text-lg">{{ $ProdukOutlet }}</p>
                </div>
            </div>

            {{-- Jumlah Transaksi --}}
            <div class="rounded-lg w-full flex items-center p-3 gap-4 text-white shadow-md" style="background: #FFAAA5">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17.414 10.414C18 9.828 18 8.886 18 7s0-2.828-.586-3.414m0 6.828C16.828 11 15.886 11 14 11h-4c-1.886 0-2.828 0-3.414-.586m10.828 0Zm0-6.828C16.828 3 15.886 3 14 3h-4c-1.886 0-2.828 0-3.414.586m10.828 0Zm-10.828 0C6 4.172 6 5.114 6 7s0 2.828.586 3.414m0-6.828Zm0 6.828ZM13 7a1 1 0 1 1-2 0a1 1 0 0 1 2 0Z"/><path stroke-linecap="round" d="M18 6a3 3 0 0 1-3-3m3 5a3 3 0 0 0-3 3M6 6a3 3 0 0 0 3-3M6 8a3 3 0 0 1 3 3m-4 9.388h2.26c1.01 0 2.033.106 3.016.308a14.9 14.9 0 0 0 5.33.118c.868-.14 1.72-.355 2.492-.727c.696-.337 1.549-.81 2.122-1.341c.572-.53 1.168-1.397 1.59-2.075c.364-.582.188-1.295-.386-1.728a1.89 1.89 0 0 0-2.22 0l-1.807 1.365c-.7.53-1.465 1.017-2.376 1.162q-.165.026-.345.047m0 0l-.11.012m.11-.012a1 1 0 0 0 .427-.24a1.49 1.49 0 0 0 .126-2.134a1.9 1.9 0 0 0-.45-.367c-2.797-1.669-7.15-.398-9.779 1.467m9.676 1.274a.5.5 0 0 1-.11.012m0 0a9.3 9.3 0 0 1-1.814.004"/><rect width="3" height="8" x="2" y="14" rx="1.5"/></g></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">Total Transaksi</h1>
                    <p class="text-lg">{{ $TransaksiOutlet }}</p>
                </div>
            </div>
            
            {{-- Total Pendapatan --}}
            <div class="rounded-lg w-full flex items-center p-3 gap-4 text-white shadow-md" style="background: #2E8B57">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 12a3 3 0 1 0 3 3a3 3 0 0 0-3-3m0 4a1 1 0 1 1 1-1a1 1 0 0 1-1 1m-.71-6.29a1 1 0 0 0 .33.21a.94.94 0 0 0 .76 0a1 1 0 0 0 .33-.21L15 7.46A1 1 0 1 0 13.54 6l-.54.59V3a1 1 0 0 0-2 0v3.59L10.46 6A1 1 0 0 0 9 7.46ZM19 15a1 1 0 1 0-1 1a1 1 0 0 0 1-1m1-7h-3a1 1 0 0 0 0 2h3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-8a1 1 0 0 1 1-1h3a1 1 0 0 0 0-2H4a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h16a3 3 0 0 0 3-3v-8a3 3 0 0 0-3-3M5 15a1 1 0 1 0 1-1a1 1 0 0 0-1 1"/></svg>
                </div>
                <div class="w-full">
                    <h1 class="text-2xl font-bold">Total Pendapatan</h1>
                    <div class="flex justify-between w-full">
                        <p class="text-lg">Rp. </p>
                        <p class="text-lg">{{ number_format($PendapatanOutlet,0 , ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Total Keuntungan --}}
            <div class="rounded-lg w-full flex items-center p-3 gap-4 text-white shadow-md" style="background: #607D8B ">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M11.5 3a4.5 4.5 0 0 1 4.336 3.292l.052.205l1.87-.467a1 1 0 0 1 1.233.84L19 7v1.81a6.5 6.5 0 0 1 1.364 1.882l.138.308H21a1 1 0 0 1 .993.883L22 12v3a1 1 0 0 1-.445.832l-.108.062l-1.168.585a6.5 6.5 0 0 1-2.02 2.325l-.259.174V20a1 1 0 0 1-.883.993L17 21h-3a1 1 0 0 1-.993-.883L13 20h-1a1 1 0 0 1-.883.993L11 21H8a1 1 0 0 1-.993-.883L7 20v-1.022a6.5 6.5 0 0 1-2.854-4.101a3 3 0 0 1-2.14-2.693L2 12v-.5a1 1 0 0 1 1.993-.117L4 11.5v.5q.002.224.09.415a6.5 6.5 0 0 1 2.938-4.411A4.5 4.5 0 0 1 11.5 3m4.5 8a1 1 0 1 0 0 2a1 1 0 0 0 0-2m-4.5-6a2.5 2.5 0 0 0-2.478 2.169A6.5 6.5 0 0 1 10.5 7h3.377l.07-.017A2.5 2.5 0 0 0 11.5 5"/></g></svg>
                </div>
                <div class="w-full">
                    <h1 class="text-2xl font-bold">Total Keuntungan</h1>
                    <div class="flex justify-between w-full">
                        <p class="text-lg">Rp. </p>
                        <p class="text-lg">{{ number_format($KeuntunganOutlet,0 , ',', '.') }}</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Monitoring Produk Terjual --}}
        <div class="w-full flex flex-col gap-8 md:flex-row md:gap-6 mb-5">
            {{-- TOP PRODUK --}}
            <div class="w-full md:w-1/2 bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-6 text-teal-600 border-b-2 border-teal-300 pb-2">Produk Favorit</h2>

                <div class="w-full overflow-x-auto overflow-y-auto" style="height: 350px;">
                    <table class="w-full table-auto text-sm text-left text-gray-700 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="py-3 px-4 border-b">Nama Produk</th>
                                <th class="py-3 px-4 border-b">Kategori</th>
                                <th class="py-3 px-4 border-b">Harga</th>
                                <th class="py-3 px-4 border-b">Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($TopProdukTerjual as $terjual)
                                <tr class="border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                                    <td class="px-6 py-4 text-left font-medium text-gray-900 dark:text-white">{{ $terjual->Produk->nama_produk }}</td>
                                    <td class="px-6 py-4 text-left font-medium text-gray-900 dark:text-white">{{ $terjual->Produk->Kategori->nama_kategori }}</td>
                                    <td class="px-6 py-4 text-left font-medium text-gray-900 dark:text-white">{{ number_format($terjual->Produk->harga_jual, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-center font-medium text-gray-900 dark:text-white">{{ $terjual->total_terjual }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">Tidak ada data produk terjual.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- PRODUK TERJUAL --}}
            <div class="w-full md:w-1/2 bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-6 text-teal-600 border-b-2 border-teal-300 pb-2">Statistik Produk</h2>

                <!-- Period Selector -->
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <!-- Product Selection Dropdown -->
                    <select id="produk-select" class="w-full md:w-1/2 border border-gray-300 text-gray-700 py-2 px-4 rounded focus:outline-none focus:ring focus:border-teal-500">
                        @foreach ($Produk as $items)
                            <option value="{{ $items->id }}">{{ $items->nama_produk }}</option>
                        @endforeach
                    </select>

                    <!-- Time Period Selection Dropdown -->
                    <select id="periode-select" class="w-full border border-gray-300 text-gray-700 py-2 px-4 rounded focus:outline-none focus:ring focus:border-teal-500">
                        <option value="hari">Hari ini</option>
                        <option value="minggu">Minggu ini</option>
                        <option value="bulan">Bulan ini</option>
                    </select>
                </div>

                <!-- Chart Section -->
                <div class="bg-gray-50 shadow-inner rounded-lg p-2">
                    <h2 class="text-lg font-semibold mb-4 text-gray-700 text-center">Total Pembelian</h2>
                    <div class="relative w-full h-60"> <!-- 16:9 Aspect Ratio -->
                        <canvas id="PembelianChart" class="absolute top-0 left-0 w-full h-full"></canvas>
                    </div>
                </div>
            </div>
        </div>


        {{-- Monitoring Pemasukan --}}
        <div class="p-2">
            <h1 class="text-2xl font-extrabold text-gray-900 mb-6 mt-4 text-left">Kalender Pemasukan</h1>
            <div id="calendar" class="calendar-container"></div>
        </div>

        {{-- Menampilkan Detail Transaksi pada tanggal tertentu --}}
        <div class="p-4 bg-gray-50 rounded-lg shadow-md">
            <!-- Search Input Container -->
            <div class="mb-6">
                <label for="search-input" class="block text-gray-700 font-semibold mb-2">Detail Transaksi : <span id="selected-date"></span></label>
                <input 
                    type="text" 
                    id="search-input" 
                    placeholder="Search nama produk..." 
                    class="border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-green-500 w-full transition duration-300 ease-in-out transform hover:shadow-lg"
                    oninput="filterTransactions()"
                >
            </div>
            <!-- Transaction Details Section -->
            <div id="transaction-details" class="space-y-4"></div>
        </div>





    </div>


    {{-- KALENDER --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

    <script>
        let pembelianChart;

        function initializeChart() {
            let ctx = document.getElementById('PembelianChart').getContext('2d');
            pembelianChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Total Pembelian',
                        data: [],
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true, // Grafik menjadi responsif
                    maintainAspectRatio: false, // Tidak menjaga rasio aspek tetap
                    scales: {
                        y: {
                            beginAtZero: true // Memulai grafik dari nol pada sumbu y
                        }
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            initializeChart();
        });

        document.getElementById('periode-select').addEventListener('change', function() {
            let selectedPeriod = this.value;
            let selectedProduct = document.getElementById('produk-select').value;

            fetchProductStats(selectedProduct, selectedPeriod);
        });

        document.getElementById('produk-select').addEventListener('change', function() {
            let selectedProduct = this.value;
            let selectedPeriod = document.getElementById('periode-select').value;

            fetchProductStats(selectedProduct, selectedPeriod);
        });

        function fetchProductStats(productId, period) {
            fetch(`/get-statistics-produk?product=${productId}&period=${period}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Fetched data:', data); // Log the data for debugging
                    updateChart(data);
                })
                .catch(error => {
                    console.error('Error fetching product stats:', error);
                });
        }

        function updateChart(data) {
            if (pembelianChart) {
                // Check if data is an array
                if (Array.isArray(data)) {
                    let labels = data.map(item => item.date);
                    let values = data.map(item => item.total_barang);

                    pembelianChart.data.labels = labels;
                    pembelianChart.data.datasets[0].data = values;
                    pembelianChart.update();
                } else {
                    console.error('Unexpected data format:', data);
                }
            } else {
                console.error('Chart is not initialized');
            }
        }

        // Add resize event listener
        window.addEventListener('resize', function() {
            if (pembelianChart) {
                pembelianChart.resize(); // Memperbarui grafik
            }
        });


        // KALENDER
        // Memformat value penghasilan
        function formatEarnings(value) {
            const screenWidth = window.innerWidth;
            if (screenWidth < 768) {
                return `${(value / 1000)}K`; // Format to K for small screens
            }
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(value); // Format with "Rp" for larger screens
        }

        // Menampilkan Kalender
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                right: 'prev,next today',
                center: 'title',
                left: '',
            },
            events: '/master/laporan/pendapatan', // Fetch earnings data from the server
            eventContent: function(arg) {
                const formattedTitle = formatEarnings(arg.event.title);
                return {
                    html: `<div class="text-center font-semibold text-sm md:text-lg">${formattedTitle}</div>` // Responsive text size
                };
            },
            eventColor: '#4CAF50', // Event background color
            eventTextColor: '#ffffff', // Event text color
            eventMaxStack: 3, // Maximum number of events to stack in a day cell
            height: 'auto', // Automatically adjust height

            dayCellDidMount: function(info) {
                // Add a hover effect for day cells
                info.el.classList.add('border', 'border-gray-300', 'rounded', 'shadow-sm'); // Add Tailwind classes
                info.el.addEventListener('mouseover', function() {
                    info.el.classList.add('bg-green-200'); // Light green on hover
                });
                info.el.addEventListener('mouseout', function() {
                    info.el.classList.remove('bg-green-200'); // Reset background color
                });
            },

            // Add dateClick event listener
            dateClick: function(info) {
                // Fetch transaction details for the clicked date
                const selectedDate = info.dateStr;
                fetchTransactionDetails(selectedDate);
            },
            titleFormat: { year: 'numeric', month: 'long' },

            
            dayHeaderDidMount: function(info) {
                info.el.classList.add('bg-gray-100', 'border-b', 'border-gray-300');
            },
            eventDidMount: function(info) {
                // Add hover effect to events
                info.el.classList.add('hover:shadow-lg', 'rounded-md');
                info.el.addEventListener('mouseover', function() {
                    info.el.classList.add('opacity-75');
                });
                info.el.addEventListener('mouseout', function() {
                    info.el.classList.remove('opacity-75');
                });
            },
        });



            calendar.render();
        });

        // Mengambil Data Detail Transaksi
        let transactionData = []; // Store fetched transaction data

        // Fetch Data Detail Transaksi
        function fetchTransactionDetails(date) {
            const selectedDateElement = document.getElementById('selected-date');
            selectedDateElement.innerText = `${new Date(date).toLocaleDateString()}`;
            fetch(`/master/laporan/pendapatan/details?date=${date}`)
                .then(response => response.json())
                .then(data => {
                    transactionData = data; // Store the fetched data
                    displayTransactionDetails(data); // Display data
                })
                .catch(error => {
                    console.error('Error fetching transaction details:', error);
                    const detailsContainer = document.getElementById('transaction-details');
                    detailsContainer.innerHTML = '<p class="text-red-500">Error fetching transaction details. Please try again later.</p>'; // Display error message
                });
        }

        // Function to display transaction details in cards
        function displayTransactionDetails(data) {
            const detailsContainer = document.getElementById('transaction-details');
            detailsContainer.innerHTML = ''; // Clear previous details

            if (data.length === 0) {
                detailsContainer.innerHTML = '<p class="text-gray-500">No transactions found for this date.</p>';
                return;
            }

            // Create and append detail cards
            data.forEach(item => {
                const detailCard = createDetailCard(item);
                detailsContainer.appendChild(detailCard);
            });
        }

        // Function to create a detail card
        function createDetailCard(detail) {
            const card = document.createElement('div');
            card.className = 'bg-white border border-gray-200 rounded-lg p-4 mb-4 shadow-lg transition-transform transform hover:scale-105 duration-300'; // Tailwind styles for the card

            // Product Name
            const productName = document.createElement('h4');
            productName.className = 'font-semibold text-xl text-gray-900 mb-2'; // Title style
            productName.innerText = `Nama Produk: ${detail.nama_produk}`;

            // Status
            const status = document.createElement('p');
            status.className = 'text-gray-600 text-sm mb-1'; // Tailwind styles for status
            status.innerText = `Status: ${detail.status}`;

            // Quantity
            const quantity = document.createElement('p');
            quantity.className = 'text-gray-600 text-sm mb-1'; // Tailwind styles for quantity
            quantity.innerText = `Jumlah: ${detail.total_barang}`;

            // Subtotal
            const subtotal = document.createElement('p');
            subtotal.className = 'text-gray-600 text-sm font-medium'; // Tailwind styles for subtotal
            subtotal.innerText = `Subtotal: Rp. ${detail.subtotal}`;

            // Add a border-top separator for better organization
            const separator = document.createElement('div');
            separator.className = 'border-t border-gray-200 my-2';

            // Append all elements to the card
            card.appendChild(productName);
            card.appendChild(status);
            card.appendChild(quantity);
            card.appendChild(separator); // Add the separator
            card.appendChild(subtotal);

            return card;

        }

        // Function to filter transactions based on search input
        function filterTransactions() {
            const searchInput = document.getElementById('search-input').value.toLowerCase();
            const detailsContainer = document.getElementById('transaction-details');
            detailsContainer.innerHTML = ''; // Clear previous details

            // Filter transaction data based on search input
            const filteredData = transactionData.filter(item => 
                item.nama_produk.toLowerCase().includes(searchInput) || 
                item.status.toLowerCase().includes(searchInput)
            );

            // Display filtered results
            if (filteredData.length > 0) {
                filteredData.forEach(item => {
                    const detailCard = createDetailCard(item);
                    detailsContainer.appendChild(detailCard);
                });
            } else {
                detailsContainer.innerHTML = '<p class="text-gray-500">No transactions found.</p>'; // No results message
            }
        }

    








    </script>
</x-master-layout>
