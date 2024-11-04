<x-master-layout :title="$title">
    <div class="w-full">
        <div class="flex justify-between flex-col md:flex-row mt-2 gap-3">
            <h1 class="text-3xl font-bold">Unit : Produk</h1>
        </div>

        <div class="flex justify-between flex-col md:flex-row items-center mt-2">
            
            <button data-modal-target="tambah-modal" data-modal-toggle="tambah-modal" class="w-full md:w-auto text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800" type="button">
                Tambah Unit
            </button>
            
            <div class="flex flex-col md:flex-row gap-3 items-start w-full md:w-auto mt-2">
                <div class="flex flex-col md:flex-row w-full">
                    <form method="GET" action="{{ route('admin-all-unit') }}" class="flex items-center flex-col md:flex-row w-full gap-2">
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

                    </form>
                </div>
                <div class="relative w-full">
                    <label for="simple-search" class="sr-only">Search</label>
                    <input type="text" id="simple-search" onkeyup="searchTable()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition duration-150 ease-in-out mb-1" placeholder="Search Unit..." required />
                </div>
            </div>
        </div>

        <div class="w-full md:w-1/3 relative overflow-x-auto shadow-md rounded-lg mt-1">
            <table id="unit-table" class="min-w-full rounded-md text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="background: gray">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-200"> 
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama Unit
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($units as $key => $unit)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                            {{ $key + 1 }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $unit->nama_unit }}
                        </td>
                        <td class="px-6 py-4 text-right flex justify-center gap-2">
                            <button data-modal-target="edit-modal{{ $unit->id }}" data-modal-toggle="edit-modal{{ $unit->id }}" 
                            class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                Edit
                            </button>
                            <button data-modal-target="popup-modal{{ $unit->id }}" data-modal-toggle="popup-modal{{ $unit->id }}" data-id="{{ $unit->id }}" onclick="document.getElementById('delete_id').value = '{{ $unit->id }}';" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5" type="button">
                                Hapus
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div id="edit-modal{{ $unit->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto fixed inset-0 z-50 justify-center items-center">
                        <div class="relative p-4 w-full max-w-2xl">
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <div class="flex items-center justify-between p-4 border-b">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        Edit Unit
                                    </h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg w-8 h-8 inline-flex justify-center items-center" data-modal-hide="edit-modal{{ $unit->id }}">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <form action="{{ route('update-unit', $unit->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="p-4 space-y-4">
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700" for="nama_unit">Nama Unit</label>
                                            <input type="text" value="{{ $unit->nama_unit }}" id="nama_unit" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" name="nama_unit" required>
                                        </div>
                                    </div>
                                    <div class="flex justify-end p-4 border-t">
                                        <button data-modal-hide="edit-modal{{ $unit->id }}" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Edit</button>
                                        <button data-modal-hide="edit-modal{{ $unit->id }}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Hapus -->
                    <div id="popup-modal{{ $unit->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto fixed inset-0 z-50 justify-center items-center">
                        <div class="relative p-4 w-full max-w-md">
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg w-8 h-8 inline-flex justify-center items-center" data-modal-hide="popup-modal{{ $unit->id }}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                                <form action="{{ route('destroy-unit', $unit->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="p-4 text-center">
                                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                        <h3 class="mb-5 text-lg font-normal text-gray-500">Apakah anda yakin akan menghapus unit <b>{{ $unit->nama_unit }}</b>? Produk dengan unit {{ $unit->nama_unit }} akan dihapus!!</h3>
                                        <input type="hidden" id="delete_id" name="id" value="">
                                        <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5">Yes, Yakin</button>
                                        <button data-modal-hide="popup-modal{{ $unit->id }}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">No, cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td colspan="4" class="text-center py-4 font-bold">No unit found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination Links -->
    <div class="flex items-center justify-between mt-4 px-2">
        <div class="text-gray-700">
            Showing <span class="font-semibold">{{ $units->firstItem() }}</span> to <span class="font-semibold">{{ $units->lastItem() }}</span> of <span class="font-semibold">{{ $units->total() }}</span> results
        </div>
        <div>
            {{ $units->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <!-- Modal Tambah -->
    <div id="tambah-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-xl max-h-full">
            <!-- Modal content -->
            <form action="{{ route('pemilik-store-unit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Tambah Unit
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="tambah-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <div class="mb-4 w-full">
                            <label class="block text-sm font-medium text-gray-700" for="nama_unit">Nama Unit</label>
                            <input type="text" id="nama_unit" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="nama_unit">
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex justify-end items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit" data-modal-hide="tambah-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tambah</button>
                        <button data-modal-hide="tambah-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- JQUERY --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    {{-- SELECT2 (SELECT WITH INPUT) --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- SCRIPT -->
    <script>
        // SELECT2 
        $(document).ready(function() {
            $("#id_label_single").select2({
                width: '100%'
            });

            
            $("#id_label_single").next('.select2-container').css({
                'margin-top': '4px',
                'height': '41px'
            });
        });

        function searchTable() {
            // Get the search input value
            const input = document.getElementById('simple-search');
            const filter = input.value.toLowerCase();

            // Get the table and tbody elements
            const table = document.getElementById('unit-table');
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

            // Remove any existing "No unit found" row before adding a new one
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
                    <td colspan="10" class="text-center py-4 font-bold">No unit found</td>
                `;
                tbody.appendChild(noResultRow);
            }
        }
    </script>

</x-master-layout>

