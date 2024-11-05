<x-master-layout :title="$title">
    <div class="w-full">
        <div class="flex justify-between mt-1">
            <h1 class="text-xl md:text-3xl font-bold">Daftar Produk : {{ $user->Outlet->nama_outlet }}</h1>
        </div>

        <div class="flex justify-between flex-col md:flex-row items-center mt-2">

            <a href="{{ route('pemilik-add-produk') }}" type="button" 
                class="w-full md:w-auto text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                Tambah Produk
            </a>
        
            <div class="flex flex-col md:flex-row gap-3 items-start w-full md:w-auto mt-4">
                <div class="flex flex-col md:flex-row w-full">
                    <form method="GET" action="{{ route('pemilik-produk') }}" class="flex items-center flex-col md:flex-row w-full gap-2">
                        <!-- Hidden Inputs -->
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="page" value="{{ request('page') }}">

                        <!-- Rows Per Page Filter -->
                        <select name="per_page" 
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 shadow-sm transition duration-150 ease-in-out w-full" 
                                id="rowsPerPage" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>

                        <!-- Role Filter -->
                        <select name="id_kategori" 
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 shadow-sm transition duration-150 ease-in-out w-full" 
                                id="id_kategori" 
                                onchange="this.form.submit()">
                            <option value="">All Kategori</option>
                            @foreach ($kategoris as $singleKategori)
                                <option value="{{ $singleKategori->id }}" 
                                        {{ request('id_kategori') == $singleKategori->id || $singleKategori->id == 'YOUR_DEFAULT_ID' ? 'selected' : '' }}>
                                    {{ $singleKategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="relative w-full">
                    <label for="simple-search" class="sr-only">Search</label>
                    <input type="text" id="simple-search" onkeyup="searchTable()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition duration-150 ease-in-out mb-1" placeholder="Search Produk..." required />
                </div>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md rounded-lg">
            <table id="produk-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="background: gray">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-700"> 
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Foto
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-3">
                            SKU
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Kategori
                        </th>
                        <th scope="col" class="px-6 py-3">
                            QTY
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Unit
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Harga
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($produks as $index => $produk)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <a target="_blank" class="w-4 h-4">
                                @if ($produk->foto && Storage::exists('assets/' . $produk->foto))
                                    <img class="object-contain w-20 h-20 sm:w-16 sm:h-16 md:w-20 md:h-20 min-w-full rounded-md" src="{{ Storage::url('assets/' . $produk->foto) }}" alt="Produk">
                                @else
                                    <img class="object-contain w-20 h-20 sm:w-16 sm:h-16 md:w-20 md:h-20 min-w-full rounded-md" src="{{ asset('public/assets/produk.png') }}" alt="Produk">
                                @endif
                            </a>
                        </th>
                        <td class="px-6 py-4">
                            {{ $produk->nama_produk }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $produk->sku }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $produk->Kategori->nama_kategori }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $produk->stok }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $produk->Unit->nama_unit }}
                        </td>
                        <td class="px-6 py-4">
                            @if($produk->status == 'Diskon')
                                {{ $produk->harga_diskon }} ({{$produk->diskon }}%)
                            @else
                                {{ $produk->harga_jual }}
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block text-base font-bold rounded-lg px-3 py-1
                                {{ 
                                    $produk->status == 'Aktif' ? 'bg-green-200 text-green-900' :
                                    ($produk->status == 'Habis' ? 'bg-red-200 text-red-900' :
                                    ($produk->status == 'Promo' ? 'bg-yellow-200 text-yellow-900' :
                                    ($produk->status == 'Diskon' ? 'bg-yellow-200 text-yellow-900' :
                                    ($produk->status == 'Baru' ? 'bg-blue-200 text-blue-900' : ''))))
                                }}">
                                {{ $produk->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="relative flex items-center justify-center space-x-2 text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900 w-fit">
                                <!-- Button for 'Ubah' -->
                                <a href="{{ route('pemilik-edit-produk', $produk->sku) }}" class="focus:outline-none">
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
                                        @if($produk->status === 'Habis')
                                            <li>
                                               <form action="{{ route('update-status-produk-outlet', $produk->id) }}" method="POST" class="block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-left">
                                                        Aktifkan
                                                    </button>
                                                </form>
                                            </li>
                                        @else
                                            <li>
                                                <form action="{{ route('update-status-produk-outlet', $produk->id) }}" method="POST" class="block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-left">
                                                        Nonaktifkan
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                        <li>
                                            <form id="delete-form-{{ $produk->id }}" action="{{ route('destroy-produk', $produk->id) }}" method="POST" class="block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-left delete-button"  data-produk-id="{{ $produk->id }}">
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
                        <td colspan="10" class="text-center py-4 font-bold">No produk found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex items-center justify-between mt-4 px-2">
        <div class="text-gray-700">
            Showing <span class="font-semibold">{{ $produks->firstItem() }}</span> to <span class="font-semibold">{{ $produks->lastItem() }}</span> of <span class="font-semibold">{{ $produks->total() }}</span> results
        </div>
        <div>
            {{ $produks->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <script>
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
                    const produkId = this.getAttribute('data-produk-id');

                    // Show SweetAlert confirmation
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda tidak bisa mengembalikan produk yang dihapus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If confirmed, submit the form
                            document.getElementById('delete-form-' + produkId).submit();
                        }
                    });
                });
            });
        });

        function searchTable() {
            // Get the search input value
            const input = document.getElementById('simple-search');
            const filter = input.value.toLowerCase();

            // Get the table and tbody elements
            const table = document.getElementById('produk-table');
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
                    <td colspan="10" class="text-center py-4 font-bold">No produk found</td>
                `;
                tbody.appendChild(noResultRow);
            }
        }
    </script>
</x-master-layout>