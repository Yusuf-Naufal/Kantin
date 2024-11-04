<x-master-layout :title="$title">
    <div class="w-full space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">Search Produk Terjual</h1>
        </div>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <form method="GET" action="{{ route('pemilik-filter-produk') }}" class="w-full flex flex-col md:flex-row md:items-center gap-4">
                <div class="flex w-full md:w-auto gap-4">
                    <!-- Filter tanggal dengan Flatpickr untuk rentang tanggal -->
                    <input 
                        type="text" id="date-range" 
                        class="bg-white w-full md:w-64 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3 shadow-md transition duration-150 ease-in-out" 
                        name="date_range" 
                        value="{{ request('date_range') }}" 
                        placeholder="Pilih Rentang Tanggal"
                    >
                    
                    <!-- Tombol submit -->
                    <button type="submit" class="bg-blue-600 text-white rounded-lg px-4 py-2 hover:bg-blue-700 transition duration-150 ease-in-out shadow-lg">
                        Filter
                    </button>
                </div>
            </form>

            <div class="md:w-auto w-full">
                <div class="flex items-center max-w-sm mx-auto">
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <input 
                            type="text" id="simple-search" onkeyup="searchTable()" 
                            class="w-full md:w-64 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3 shadow-md" 
                            placeholder="Search Produk..." 
                            required 
                        />
                    </div>
                </div>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-lg rounded-lg mt-2">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Produk terjual pada tanggal: {{ $dateRange ?? 'Masukkan Tanggalnya' }}</h2>
            
            <table id="transaksi-table"  class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="background: gray">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-700"> 
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama Produk</th>
                        <th scope="col" class="px-6 py-3">Jumlah</th>
                        <th scope="col" class="px-6 py-3">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($details as $detail)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">{{ $detail->nama_produk }}</td>
                            <td class="px-6 py-4">{{ $detail->total_barang }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-800">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b">
                            <td colspan="4" class="text-center py-4 font-bold text-gray-500">Masukkan tanggal yang pasti</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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


        // CARI DATA TRANSAKSI
        function searchTable() {
            // Get the search input value
            const input = document.getElementById('simple-search');
            const filter = input.value.toLowerCase();

            // Get the table and tbody elements
            const table = document.getElementById('transaksi-table');
            const tbody = table.getElementsByTagName('tbody')[0];
            const rows = tbody.getElementsByTagName('tr');

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
            }
        }
    </script>
</x-master-layout>