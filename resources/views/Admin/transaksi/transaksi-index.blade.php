<x-admin-layout :title="$title">
    <div class="w-full">
        <div class="flex justify-between w-full">
            <h1 class="text-3xl font-bold">Riwayat Transaksi</h1> 
        </div>
        <div class="w-full flex justify-between mt-2 gap-2 flex-col md:flex-row">
            <form method="GET" action="{{ route('admin-transaksi') }}" class="flex flex-col md:flex-row items-center w-full space-y-2 md:space-y-0 md:space-x-2">
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
                        <input type="text" id="simple-search" onkeyup="searchTable()" class="w-full md:w-auto bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Transaksi..." required />
                    </div>
                </div>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md rounded-lg mt-1">
            <table id="transaksi-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="background: gray">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-700"> 
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Tanggal
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Resi
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama Outlet
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Jumlah
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($transaksis as $index => $transaksi)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{ $transaksi->tanggal_transaksi }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('detail-transaksi', $transaksi->resi) }}" class="text-blue-700">
                                {{ $transaksi->resi }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            {{ $transaksi->Outlet->nama_outlet }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $transaksi->total_barang }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $transaksi->total_belanja }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $transaksi->status }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="relative flex items-center justify-center space-x-2 text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900 w-fit">
                                <!-- Button for 'Ubah' -->
                                <a href="{{ route('admin-edit-transaksi', $transaksi->resi) }}" type="button" 
                                    class="focus:outline-none">
                                    Ubah
                                </a>

                                <!-- Dropdown Toggle Button -->
                                <button class="dropdown-toggle-button" data-dropdown-id="dropdown-{{ $index }}" type="button" 
                                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none">
                                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>

                                <!-- Dropdown Menu -->
                                <div id="dropdown-{{ $index }}" class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg">
                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                                        <li>
                                            <form id="delete-form-{{ $transaksi->id }}" action="{{ route('destroy-transaksi', $transaksi->id) }}" method="POST" class="block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="delete-button block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-left" data-transaksi-id="{{ $transaksi->id }}">
                                                    Hapus
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td colspan="10" class="text-center py-4 font-bold">No transaksi found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination Links -->
    <div class="flex items-center justify-between mt-4 px-4">
        <div class="text-gray-700">
            Showing <span class="font-semibold">{{ $transaksis->firstItem() }}</span> to <span class="font-semibold">{{ $transaksis->lastItem() }}</span> of <span class="font-semibold">{{ $transaksis->total() }}</span> results
        </div>
        <div>
            {{ $transaksis->links('vendor.pagination.tailwind') }}
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

        // HAPUS TRANSAKSI
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-button');

            // Handle dropdown toggle
            document.querySelectorAll('.dropdown-toggle-button').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.stopPropagation(); // Prevent event from bubbling up to the document
                    const dropdownId = this.getAttribute('data-dropdown-id');
                    const dropdownMenu = document.getElementById(dropdownId);
                    // Toggle visibility of the associated dropdown
                    dropdownMenu.classList.toggle('hidden');
                });
            });

            // Hide dropdown menu when clicking outside
            document.addEventListener('click', function(event) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    if (!menu.contains(event.target) && !menu.previousElementSibling.contains(event.target)) {
                        menu.classList.add('hidden');
                    }
                });
            });

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const transaksiId = this.getAttribute('data-transaksi-id');

                    // Show SweetAlert confirmation
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda tidak bisa mengembalikan Transaksi yang dihapus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If confirmed, submit the form
                            document.getElementById('delete-form-' + transaksiId).submit();
                        }
                    });
                });
            });
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
</x-admin-layout>