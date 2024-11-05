<x-admin-layout :title="$title">
    <div class="w-full">
        {{-- TABLE PENGAJUAN --}}
        <div class="mb-1">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Daftar Pengajuan</h1>
            <div class="flex justify-between flex-col md:flex-row items-center mt-2">
            
                <div class="w-full md:w-auto flex flex-col md:flex-row">
                    <form method="GET" action="{{ route('admin-pengajuan-outlet') }}" class="flex items-center flex-col md:flex-row w-full gap-2">
                        <!-- Hidden Inputs -->
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="page" value="{{ request('page') }}">

                        <!-- Status Filter -->
                        <select name="status" 
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 shadow-sm transition duration-150 ease-in-out w-full" 
                                id="status" 
                                onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                            <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>

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
                
                <div class="flex flex-col md:flex-row gap-2 items-start w-full md:w-auto mb-4">
                    <div class="relative w-full">
                        <label for="simple-search" class="sr-only">Search</label>
                        <input type="text" id="simple-search" onkeyup="searchTable()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition duration-150 ease-in-out" placeholder="Search Pengajuan..." required />
                    </div>
                </div>
            </div>
        </div>

        </div>
            <div class="relative overflow-hidden shadow-md rounded-lg">
                <div class="overflow-y-auto">
                    <table id="pengajuan-table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400 bg-gray-50">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">Foto</th>
                                <th scope="col" class="px-6 py-3">Nama</th>
                                <th scope="col" class="px-6 py-3">Pemilik</th>
                                <th scope="col" class="px-6 py-3">Telepon</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengajuans as $pengajuan)
                            <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" data-status="{{ $pengajuan->status }}">
                                <td class="px-6 py-4">
                                    <img class="object-contain w-20 h-20 rounded-md" src="{{ $pengajuan->foto ? Storage::url('app/public/assets/' . $pengajuan->foto) : asset('public/assets/icon-outlet.png') }}" alt="Outlet">
                                </td>
                                <td class="px-6 py-4">{{ $pengajuan->nama_outlet }}</td>
                                <td class="px-6 py-4">{{ $pengajuan->User->name }}</td>
                                <td class="px-6 py-4">{{ $pengajuan->no_telp }}</td>
                                <td class="px-6 py-4">{{ $pengajuan->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-block text-base font-bold rounded-lg px-3 py-1
                                        {{ $pengajuan->status == 'Approved' ? 'bg-green-200 text-green-900' :
                                        ($pengajuan->status == 'Rejected' ? 'bg-red-200 text-red-900' :
                                            ($pengajuan->status == 'Pending' ? 'bg-gray-200 text-gray-900' : '')) }}">
                                        {{ $pengajuan->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        @if ($pengajuan->status == 'Pending')
                                            <!-- Tombol untuk status Pending -->
                                            <a href="#" id="setuju-button" data-id="{{ $pengajuan->id }}" class="px-3 py-2 text-xs font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-all duration-150" aria-label="Setujui">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17px" height="17px" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M16.972 6.251a2 2 0 0 0-2.72.777l-3.713 6.682l-2.125-2.125a2 2 0 1 0-2.828 2.828l4 4c.378.379.888.587 1.414.587l.277-.02a2 2 0 0 0 1.471-1.009l5-9a2 2 0 0 0-.776-2.72"/>
                                                </svg>
                                            </a>

                                            <a href="#" id="tolak-button" data-id="{{ $pengajuan->id }}" class="px-3 py-2 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-all duration-150" aria-label="Tolak">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17px" height="17px" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15l-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152l2.758 3.15a1.2 1.2 0 0 1 0 1.698"/>
                                                </svg>
                                            </a>
                                        @endif

                                        <a href="{{ route('admin-detail-pengajuan', $pengajuan->id) }}" id="detail-button" class="px-3 py-2 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all duration-150" aria-label="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17px" height="17px" viewBox="0 0 20 20" fill="currentColor">
                                                <g>
                                                    <path fill-rule="evenodd" d="M10 16.5c4.897 0 9-2.308 9-5.5s-4.103-5.5-9-5.5S1 7.808 1 11s4.103 5.5 9 5.5m0-9c3.94 0 7 1.722 7 3.5s-3.06 3.5-7 3.5s-7-1.722-7-3.5s3.06-3.5 7-3.5" clip-rule="evenodd"/>
                                                    <path d="M9 3.5a1 1 0 0 1 2 0v3a1 1 0 1 1-2 0zm4.02.304a1 1 0 0 1 1.96.392l-.5 2.5a1 1 0 0 1-1.96-.392zm-6.04 0a1 1 0 0 0-1.96.392l.5 2.5a1 1 0 0 0 1.96-.392zM2.857 4.986a1 1 0 1 0-1.714 1.029l1.5 2.5a1 1 0 1 0 1.714-1.03zm14.286 0a1 1 0 0 1 1.715 1.029l-1.5 2.5a1 1 0 0 1-1.716-1.03z"/>
                                                    <path fill-rule="evenodd" d="M10 14a3.5 3.5 0 1 0 0-7a3.5 3.5 0 0 0 0 7m0-5a1.5 1.5 0 1 1 0 3a1.5 1.5 0 0 1 0-3" clip-rule="evenodd"/>
                                                </g>
                                            </svg>
                                        </a>

                                        @if ($pengajuan->status == 'Rejected' || $pengajuan->status == 'Approved')
                                            <!-- Tombol untuk status Rejected atau Approved -->
                                            <a href="#" id="hapus-button" data-id="{{ $pengajuan->id }}" class="px-3 py-2 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-all duration-150" aria-label="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17px" height="17px" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M19 4h-3.5l-1-1h-5l-1 1H5v2h14M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6z"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 font-bold">No pengajuan found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="flex items-center justify-between mt-4 px-2">
                <div class="text-gray-700">
                    Showing <span class="font-semibold">{{ $pengajuans->firstItem() }}</span> to <span class="font-semibold">{{ $pengajuans->lastItem() }}</span> of <span class="font-semibold">{{ $pengajuans->total() }}</span> results
                </div>
                <div>
                    {{ $pengajuans->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>



    <script>
        document.querySelectorAll('#setuju-button').forEach((button) => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const pengajuanId = this.getAttribute('data-id');

                if (!pengajuanId) {
                    Swal.fire('Error!', 'Pengajuan ID not found.', 'error');
                    return;
                }

                Swal.fire({
                    title: 'Apa kamu yakin?',
                    text: 'Outlet akan ditambah ke daftar outlet!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, setuju!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`pengajuan/${pengajuanId}/approve`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Approve!',
                                    text: 'Pengajuan disetujui!',
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#3085d6',
                                }).then(() => {
                                    location.reload();  // Reload setelah sukses
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.message || 'Gagal menyetujui pengajuan.',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#3085d6',
                                });
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Proses error',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#3085d6',
                            });
                        });
                    }
                });
            });
        });

        // TOLAK PENGAJUAN
        document.querySelectorAll('#tolak-button').forEach((button) => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const pengajuanId = this.getAttribute('data-id');

                if (!pengajuanId) {
                    Swal.fire('Error!', 'Pengajuan ID not found.', 'error');
                    return;
                }

                Swal.fire({
                    title: 'Apa kamu yakin?',
                    text: 'Menolak pengajuan outlet ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Tolak!',
                }).then((result) => {
                    if (result.isConfirmed) {
                       fetch(`pengajuan/${pengajuanId}/reject`, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                        })
                            .then((response) => response.json())
                            .then((data) => {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'Rejected!',
                                        text: 'Pengajuan ditolak!',
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#3085d6',
                                    }).then(() => {
                                        location.reload();  // Reload setelah sukses
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: data.message || 'Gagal menolak pengajuan.',
                                        icon: 'error',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#3085d6',
                                    });
                                }
                            })
                            .catch((error) => {
                                console.error('Error:', error);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Proses error',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#3085d6',
                                });
                            });
                    }
                });
            });
        });

        // HAPUS PENGAJUAN
        document.querySelectorAll('#hapus-button').forEach((button) => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const pengajuanId = this.getAttribute('data-id');

                if (!pengajuanId) {
                    Swal.fire('Error!', 'Pengajuan ID not found.', 'error');
                    return;
                }

                Swal.fire({
                    title: 'Pengajuan dihapus?',
                    text: 'User dapat mengajukan outlet lagi!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Hapus!',
                }).then((result) => {
                    if (result.isConfirmed) {
                       fetch(`pengajuan/${pengajuanId}/destroy`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                        })
                            .then((response) => response.json())
                            .then((data) => {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'Destroy!',
                                        text: 'Pengajuan dihapus!',
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#3085d6',
                                    }).then(() => {
                                        location.reload();  // Reload setelah sukses
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: data.message || 'Gagal menghapus pengajuan.',
                                        icon: 'error',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#3085d6',
                                    });
                                }
                            })
                            .catch((error) => {
                                console.error('Error:', error);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Proses error',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#3085d6',
                                });
                            });
                    }
                });
            });
        });

        // SEARCH DATA PENGAJUAN
        function searchTable() {
            // Get the search input value
            const input = document.getElementById('simple-search');
            const filter = input.value.toLowerCase();

            // Get the table and tbody elements
            const table = document.getElementById('pengajuan-table');
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
                    <td colspan="10" class="text-center py-4 font-bold">No pengajuan found</td>
                `;
                tbody.appendChild(noResultRow);
            }
        }



    </script>
</x-admin-layout>
