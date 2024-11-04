<x-admin-layout :title="$title">
    <style>
        
    </style>
    <div class="w-full">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-4">Dashboard</h1>

        
        <div class="py-2 px-1">
            {{-- Monitoring User, Transaksi, Jumlah Barang --}}
            <div class="w-full flex flex-col md:flex-row gap-2 ">
                {{-- Total User --}}
                <div class="rounded-lg w-full flex items-center p-3 gap-4 text-white shadow-md" style="background: #74C0FC">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 32 32"><path fill="currentColor" d="M12 8a4 4 0 1 1 8 0a4 4 0 0 1-8 0m-3.5 8c0-1.152.433-2.204 1.146-3H6a3 3 0 0 0-3 3v3.5a1 1 0 0 0 1 1h4.5zm15 0a4.48 4.48 0 0 0-1.146-3H26a3 3 0 0 1 3 3v3.5a1 1 0 0 1-1 1h-4.5zM3 23.5A1.5 1.5 0 0 1 4.5 22h23a1.5 1.5 0 0 1 1.5 1.5a4.5 4.5 0 0 1-4.5 4.5h-17A4.5 4.5 0 0 1 3 23.5m1-15a3.5 3.5 0 1 1 7 0a3.5 3.5 0 0 1-7 0m17 0a3.5 3.5 0 1 1 7 0a3.5 3.5 0 0 1-7 0M10 16a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3v4.5H10z"/></svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Total User</h1>
                        <p class="text-lg">{{ $AllUser ?? 0 }}</p>
                    </div>
                </div>

                {{-- Total Outlet --}}
                <div class="rounded-lg w-full flex items-center p-3 gap-4 text-white shadow-md" style="background: #F4A261">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24"><path fill="currentColor" d="M15.5 22q-.625 0-1.062-.437T14 20.5V19h8v1.5q0 .625-.437 1.063T20.5 22zM4 20q-.825 0-1.412-.587T2 18V6q0-.825.588-1.412T4 4h16q.825 0 1.413.588T22 6v5h-2V6h-7v5q-.825 0-1.412.588T11 13v7zm10.575-2q-.7 0-1.125-.55t-.3-1.25l.4-2q.125-.525.525-.862T15 13h6q.525 0 .925.337t.525.863l.4 2q.125.7-.3 1.25t-1.125.55zM5 16h5v-2H5zm0-3h5v-2H5zm0-3h5V8H5zm9 0V8h5v2z"/></svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Total Outlet</h1>
                        <p class="text-lg">{{ $AllOutlet ?? 0 }}</p>
                    </div>
                </div>

                {{-- Total Transaksi --}}
                <div class="rounded-lg w-full flex items-center p-3 gap-4 text-white shadow-md" style="background: #F28482">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 56 56"><path fill="currentColor" d="m41.266 19.117l8.812-5.015c-.352-.352-.774-.633-1.289-.915l-16.523-9.42C30.813 2.946 29.406 2.5 28 2.5s-2.812.445-4.266 1.266L18.977 6.46ZM28 26.641l10.008-5.672l-22.195-12.68l-8.602 4.899c-.516.28-.937.562-1.29.914ZM29.594 53.5c.164-.047.304-.117.469-.21l18.351-10.454c2.18-1.242 3.375-2.508 3.375-5.906V18.672c0-.703-.07-1.266-.187-1.781L29.594 29.453Zm-3.188 0V29.453L4.4 16.891a7.8 7.8 0 0 0-.188 1.78V36.93c0 3.398 1.195 4.664 3.375 5.906l18.352 10.453c.164.094.304.164.468.211"/></svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Total Produk</h1>
                        <p class="text-lg">{{ $AllProduk ?? 0 }}</p>
                    </div>
                </div>


                {{-- Total Penghasilan --}}
                <div class="rounded-lg w-full flex items-center p-3 gap-4 text-white shadow-md" style="background: #2D6A4F">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 14 14"><path fill="currentColor" fill-rule="evenodd" d="M.658.44A1.5 1.5 0 0 1 1.718 0h5.587a1.5 1.5 0 0 1 1.06.44l3.414 3.414a1.5 1.5 0 0 1 .44 1.06V12.5a1.5 1.5 0 0 1-1.5 1.5h-9a1.5 1.5 0 0 1-1.5-1.5v-11c0-.398.158-.78.44-1.06ZM5.33 4.527a.75.75 0 0 1 .175 1.047L4.108 7.53a.75.75 0 0 1-1.14.094l-.838-.838a.75.75 0 0 1 1.06-1.06l.212.211l.882-1.234a.75.75 0 0 1 1.046-.175Zm.95 1.847a.75.75 0 0 1 .75-.75h2.5a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75m0 3.969a.75.75 0 0 1 .75-.75h2.5a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75m-.775-.738a.75.75 0 1 0-1.22-.872l-.883 1.235l-.212-.212a.75.75 0 0 0-1.06 1.06l.838.838a.75.75 0 0 0 1.14-.094z" clip-rule="evenodd"/></svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Pengajuan</h1>
                        <p class="text-lg">{{ $AllPengajuan ?? 0 }}</p>
                    </div>
                </div>
            </div>


            {{-- Monitoring Penghasilan --}}
            <div class="w-full grid grid-cols-1 lg:grid-cols-3 gap-4 mt-4">

                {{-- Penghasilan Tiap Outlet --}}
                <div class="rounded-lg p-6 shadow-lg bg-white">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2 text-left">Penghasilan Outlet</h1>
                    <div class="overflow-y-auto" style="max-height: 350px;">
                        <table class="min-w-full bg-white text-left text-sm text-gray-700 rounded-lg shadow-md">
                            <thead class="bg-gray-200 rounded-t-lg">
                                <tr>
                                    <th class="px-4 py-3 border-b border-gray-300 font-semibold text-gray-800">Nama Outlet</th>
                                    <th class="px-4 py-3 border-b border-gray-300 font-semibold text-gray-800 text-right">Penghasilan</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Penghasilan Semua Outlet --}}
                                @forelse($PenghasilanOutlet as $outlet)
                                    <tr class="border-b hover:bg-gray-100 transition-colors duration-200">
                                        <td class="p-4">{{ $outlet['nama_outlet'] }}</td>
                                        <td class="p-4 text-right">Rp. {{ number_format($outlet['penghasilan'], 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr class="border-b hover:bg-gray-100 transition-colors duration-200">
                                        <td colspan="2" class="p-4 text-center">Tidak ada data</
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Grafik Penghasilan --}}
                <div class="rounded-lg p-4 shadow-lg bg-white">
                    <div class="flex justify-between flex-col md:flex-row">
                        <h1 class="text-2xl font-bold text-gray-700">Grafik Penghasilan</h1>
                        <select name="periode" id="periode-select" class="block appearance-none w-full md:w-auto bg-gray-200 border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500 transition duration-150 ease-in-out">
                            <option value="minggu">Mingguan</option>
                            <option value="bulan">Bulanan</option>
                            <option value="tahun">Tahunan</option>
                        </select>
                    </div>
                    <div class="relative w-full h-96">
                        <canvas id="penghasilanChart" style="width: 100%; height: 100%;"></canvas>
                    </div>
                </div>

                {{-- Total Penghasilan --}}
                <div class="rounded-lg p-6 shadow-lg bg-white">
                    <h1 class="text-2xl font-bold text-gray-700 mb-4">Total Penghasilan</h1>
                    <div class="text-2xl font-semibold text-green-500 mb-6 text-right flex justify-between">
                        <h1>Rp. </h1>
                        <h1>{{ number_format($TotalPenghasilan,0 , ',', '.') ?? 0 }}</h1>
                    </div>

                    {{-- Penghasilan Tertinggi --}}
                    <div class="bg-gray-100 p-4 rounded-lg mb-6">
                        <p class="text-sm font-medium text-gray-500">Penghasilan Tertinggi (minggu ini)</p>
                        <div class="flex justify-between text-2xl font-bold text-blue-600">
                            <p class="">Rp. </p>
                            <p class="">{{ number_format($PenghasilanTertinggi->total_belanja ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    {{-- Grafik Batang Penghasilan / Minggu --}}
                    <div class="mt-10">
                        <canvas id="penghasilanMingguanChart" class="w-full h-52"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function formatRupiah(angka) {
                return 'Rp. ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            let chartInstance;

            const fetchData = (periode) => {
                fetch(`/get-penghasilan-outlet?periode=${periode}`, {
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
                    console.log('Data Outlet:', data); // Log data untuk verifikasi

                    if (Array.isArray(data) && data.length > 0) {
                        const labels = []; // Menyimpan semua label
                        const datasets = []; // Menyimpan dataset untuk setiap outlet

                        // Loop melalui setiap outlet dalam data
                        data.forEach(outlet => {
                            const outletLabels = outlet.data.map(item => item.label);
                            const penghasilanData = outlet.data.map(item => item.total_penghasilan);

                            // Tambahkan label ke array label jika belum ada
                            outletLabels.forEach(label => {
                                if (!labels.includes(label)) {
                                    labels.push(label);
                                }
                            });

                            // Tambahkan dataset untuk outlet ini
                            datasets.push({
                                label: outlet.nama_outlet, // Nama outlet
                                data: penghasilanData,
                                borderColor: getRandomColor(),
                                fill: false,
                                tension: 0.1
                            });
                        });

                        console.log('Labels:', labels);
                        console.log('Datasets:', datasets);
                        updateChart(labels, datasets); // Perbarui grafik
                    } else {
                        console.warn('Data tidak valid atau kosong');
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
            };

            const updateChart = (labels, datasets) => {
                if (chartInstance) {
                    chartInstance.destroy();
                }

                const ctx = document.getElementById('penghasilanChart').getContext('2d');
                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: datasets // Gunakan datasets yang baru
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return formatRupiah(tooltipItem.raw);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                display: false,
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return formatRupiah(value);
                                    }
                                }
                            }
                        }
                    }
                });
            };

            function getRandomColor() {
                const letters = '0123456789ABCDEF';
                let color = '#';
                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }



            document.querySelector('#periode-select').addEventListener('change', function() {
                const periode = this.value;
                fetchData(periode);
            });

            fetchData('minggu');
        });

        const ctx = document.getElementById('penghasilanMingguanChart').getContext('2d');
        const penghasilanTiapMinggu = @json($PenghasilanTiapMinggu);
        
        // Ambil label dan data
        const labels = penghasilanTiapMinggu.map(item => `Minggu ${item.minggu}`);
        const data = penghasilanTiapMinggu.map(item => item.total_penghasilan);

        // Buat Chart
        const penghasilanChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Penghasilan (Rp)',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: false,
                            text: 'Total Penghasilan (Rp)'
                        }
                    },
                    x: {
                        title: {
                            display: false,
                            text: 'Minggu'
                        }
                    }
                }
            }
        });

    </script>
</x-admin-layout>