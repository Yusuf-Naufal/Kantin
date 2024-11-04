<x-master-layout :title="$title">
    <div class="w-full">
        {{-- INFO KEPEMILIKAN OUTLET --}}
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Informasi Outlet</h1>

        <div class="flex flex-col md:flex-row gap-8 bg-white shadow-lg rounded-lg p-6">
            <!-- Image Section -->
            <div class="w-full md:w-1/3 flex justify-center items-center">
                <img src="{{ Storage::url('assets/' . $outlet->foto) }}" alt="Outlet Image" class="w-full h-64 object-contain rounded-lg shadow-md border border-gray-200">
            </div>

            <!-- Outlet Details Section -->
            <div class="w-full md:w-2/3 space-y-6">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-3xl font-bold text-gray-700">{{ $outlet->nama_outlet }}</h1>
                    <a href="{{ route('pemilik-edit-outlet', $outlet->uid) }}" type="button" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">
                        Ubah
                    </a>
                </div>

                <!-- Details Section -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="w-1/3 font-semibold text-gray-700">Nama Pemilik: </label>
                        <p class="w-2/3 text-gray-600 text-right">{{ $outlet->pemilik }}</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="w-1/3 font-semibold text-gray-700">Email Outlet: </label>
                        <p class="w-2/3 text-gray-600 text-right">{{ $outlet->email }}</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="w-1/3 font-semibold text-gray-700">Contact: </label>
                        <p class="w-2/3 text-gray-600 text-right">{{ $outlet->no_telp }}</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="w-1/3 font-semibold text-gray-700">Status: </label>
                        <p class="w-2/3 text-gray-600 text-right">{{ $outlet->status }}</p>
                    </div>
                </div>

                <!-- Social Media Buttons -->
                <div class="flex flex-wrap gap-4">
                    <a href="{{ $outlet->instagram ? 'https://www.instagram.com/'.$outlet->instagram : '#' }}" style="display: flex; align-items: center; padding: 0.625rem 0.5rem; font-size: 0.875rem; font-weight: 500; color: white; background: linear-gradient(to right, #833AB4, #FD1D1D, #FDCB58); border-radius: 0.5rem; transition: opacity 0.3s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'"  class="flex items-center px-2 py-2.5 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg {{ $outlet->instagram ? '' : 'cursor-not-allowed' }}" {{ $outlet->instagram ? '' : 'disabled' }}>
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4zm9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8A1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5a5 5 0 0 1-5 5a5 5 0 0 1-5-5a5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3"/>
                        </svg>
                        {{ $outlet->instagram ? '@'.$outlet->instagram : 'Instagram' }}
                    </a>

                    <a href="{{ $outlet->facebook ? 'https://www.facebook.com/'.$outlet->facebook : '#' }}" class="flex items-center px-2 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-500 rounded-lg {{ $outlet->facebook ? '' : 'cursor-not-allowed' }}" {{ $outlet->facebook ? '' : 'disabled' }}>
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
                            <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
                        </svg>
                        {{ $outlet->facebook ?: 'Facebook' }}
                    </a>

                    <a href="{{ $outlet->tiktok ? 'https://www.tiktok.com/@'.$outlet->tiktok.'?lang=id-ID' : '#' }}" class="flex items-center px-2 py-2.5 text-sm font-medium text-white bg-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-500 rounded-lg {{ $outlet->tiktok ? '' : 'cursor-not-allowed' }}" {{ $outlet->tiktok ? '' : 'disabled' }}>
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <path fill="#ffffff" stroke="#ffffff" stroke-linejoin="round" stroke-width="3.83" d="M21.358 19.14q-8.833-.426-12.28 6.298c-3.446 6.725-.598 17.729 10.9 17.729c11.5 0 11.832-11.112 11.832-12.276V17.875q3.69 2.336 6.22 2.813q2.533.476 3.22.422v-6.476q-2.342-.282-4.05-1.076c-1.709-.794-5.096-2.997-5.096-6.226q.003.024 0-2.499h-7.118q-.031 23.724 0 26.058c.031 2.334-1.78 5.6-5.45 5.6c-3.672 0-5.483-3.263-5.483-5.367c0-1.288.443-3.155 2.272-4.538c1.085-.82 2.59-1.148 3.178-1.148z"></path>
                        </svg>
                        {{ $outlet->tiktok ? '@'.$outlet->tiktok : 'TikTok' }}
                    </a>
                </div>
            </div>
        </div>

        {{-- INFORMASI PENJUALAN --}}
        <div class="flex justify-between items-center flex-row mb-6 mt-4">
            <h1 class="text-4xl font-extrabold text-gray-900">Penjualan Hari Ini</h1>
        </div>

        <div class="w-full flex flex-col md:flex-row gap-8 bg-white rounded-lg p-6 shadow-lg border border-gray-200">
            <!-- Tabel Penjualan -->
            <div class="w-full md:w-2/3 relative overflow-x-auto overflow-y-auto rounded-lg" style="height: 230px;">
                <table id="penjualan-table" class="w-full text-sm text-left text-gray-700 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center">
                                Nama Produk
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Kategori
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Total Terjual
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        @forelse ($ProdukTerjual as $index => $terjual)
                        <tr class="border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                            <td class="px-6 py-4 text-center font-medium text-gray-900 dark:text-white">
                                {{ $terjual->Produk->nama_produk ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $terjual->Produk->Kategori->nama_kategori ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $terjual->total_terjual ?? 0 }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 font-semibold text-gray-600 dark:text-gray-300">
                                Belum ada penjualan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Informasi Penghasilan & Keuntungan -->
            <div class="w-full md:w-1/3">
                <div class="mb-3">
                    <h1 class="text-xl font-semibold text-gray-700">Penghasilan</h1>
                    <div class="border rounded-lg border-gray-300 bg-gray-50 w-full flex justify-between items-center p-4 mt-2 shadow-sm">
                        <h1 class="text-lg font-medium text-gray-500">Rp</h1>
                        <h1 class="text-xl font-semibold text-green-800 ">{{ number_format($TransaksiHariIni,0, ',', '.') }}</h1>
                    </div>
                </div>
                <div>
                    <h1 class="text-xl font-semibold text-gray-700">Keuntungan</h1>
                    <div class="border rounded-lg border-gray-300 bg-gray-50 w-full flex justify-between items-center p-4 mt-2 shadow-sm">
                        <h1 class="text-lg font-medium text-gray-500">Rp</h1>
                        <h1 class="text-xl font-semibold text-blue-800">{{ number_format($KeuntunganHariIni, 0, ',', '.') }}</h1>
                    </div>
                </div>
            </div>

        </div>



        {{-- STATISTIK PENJUALAN --}}
        <div class="container mx-auto">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-6 mt-4 text-left">Statistik Penjualan</h1>
            
            <div class="flex justify-start mb-6">
                <select class="border border-gray-300 text-gray-700 py-2 px-4 rounded focus:outline-none focus:ring focus:border-blue-500" id="periode-select">
                    <option value="hari">Hari</option>
                    <option value="minggu">Minggu</option>
                    <option value="bulan">Bulan</option>
                    <option value="tahun">Tahun</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Bar Chart for Penghasilan -->
                <div class="bg-white shadow-lg rounded-lg p-4">
                    <h2 class="text-lg font-semibold mb-2 text-gray-700 text-center">Total Penghasilan</h2>
                    <div class="relative w-full h-64 md:h-80">
                        <canvas id="Penghasilan"></canvas>
                    </div>
                </div>

                <!-- Bar Chart for Transaksi -->
                <div class="bg-white shadow-lg rounded-lg p-4">
                    <h2 class="text-lg font-semibold mb-2 text-gray-700 text-center">Total Transaksi</h2>
                    <div class="relative w-full h-64 md:h-80">
                        <canvas id="Transaksi"></canvas>
                    </div>
                </div>
            </div>
        </div>



    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            const fetchData = (periode) => {
                fetch(`/get-statistics?periode=${periode}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const labels = data.map(item => item.label);
                    const penghasilanData = data.map(item => item.total_penghasilan);
                    const transaksiData = data.map(item => item.total_transaksi);

                    updateCharts(labels, penghasilanData, transaksiData);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
            };

            document.querySelector('#periode-select').addEventListener('change', function() {
                const periode = this.value;
                fetchData(periode);
            });

            const updateCharts = (labels, penghasilanData, transaksiData) => {
                penghasilanChart.data.labels = labels;
                penghasilanChart.data.datasets[0].data = penghasilanData;
                penghasilanChart.update();

                transaksiChart.data.labels = labels;
                transaksiChart.data.datasets[0].data = transaksiData;
                transaksiChart.update();
            };

            // Inisialisasi chart
            const ctxPenghasilan = document.getElementById('Penghasilan').getContext('2d');
            const ctxTransaksi = document.getElementById('Transaksi').getContext('2d');

            const penghasilanChart = new Chart(ctxPenghasilan, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Penghasilan',
                        data: [],
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, 
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const transaksiChart = new Chart(ctxTransaksi, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Transaksi',
                        data: [],
                        backgroundColor: 'rgba(153, 102, 255, 0.6)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, 
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Fetch data for initial period
            fetchData('hari');
        });

        
    </script>
</x-master-layout>
