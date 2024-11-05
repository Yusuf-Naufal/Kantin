<x-layout :title="$title">

    <div class="max-w-5xl mx-auto w-full flex-col p-6 mt-14 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <h1 class="text-center text-3xl font-bold mb-8 text-gray-800 dark:text-white">Checkout</h1>
        
        {{-- Keterangan Kantin --}}
        <div class="mb-6">
            <div class="flex justify-between mb-2">
                <h1 class="font-semibold text-gray-800 dark:text-gray-200">Nama Kantin:</h1>
                <h2 class="text-gray-600 dark:text-gray-400">{{ $outlet->nama_outlet }}</h2>
            </div>

            <div class="flex justify-between mb-2">
                <h1 class="font-semibold text-gray-800 dark:text-gray-200">No Telp Kantin:</h1>
                <h2 class="text-gray-600 dark:text-gray-400">{{ $outlet->no_telp }}</h2>
            </div>
        </div>

        <form action="" id="OrderForm">
            @csrf
            <input class="hidden" id="IdOutlet" value="{{ $outlet->id }}"></input>
            {{-- <input type="hidden" id="resi" name="resi" value="generateResi()"> --}}
            <input type="text" name="" id="" class="hidden">
            {{-- Data Diri --}}
            <div class="w-full mb-6">
                <div class="flex gap-4 flex-col lg:flex-row mb-4">
                    <div class="w-full">
                        <label class="block text-sm font-medium text-gray-700" for="nama_pemesan">Nama Lengkap</label>
                        <input type="text" id="nama_pemesan" name="nama_pemesan" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                    </div>
                </div>
                <div class="flex gap-4 flex-col lg:flex-row mb-4">
                    <div class="w-full">
                        <label class="block text-sm font-medium text-gray-700" for="no_telp">No Telepon</label>
                        <input type="text" id="no_telp" name="no_telp" maxlength="20" oninput="this.value=this.value.replace(/[^0-9 +\-]/g,'');" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm" required >
                    </div>
                </div>
            </div>
    
            {{-- Pilihan Takeaway / Pick up --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Pilihan:</h2>
                <select name="metode" id="metode" class="mt-2 block w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-600 dark:focus:ring-green-500 focus:border-green-600 dark:focus:border-green-500" required>
                    <option value="" disabled selected>Pilih Metode</option> 
                    <option value="PickUp">Ambil di Tempat</option>
                    <option value="Delivery">Diantar</option>
                </select>
    
                {{-- Form jika pilih PickUp --}}
                <div id="pickupOptions" class="hidden w-full mt-4">
                    <div class="flex gap-4 flex-col lg:flex-row mb-4">
                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700" for="jam_ambil">Jam Ambil</label>
                            <input type="time" id="jam_ambil" name="jam_ambil" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                        </div>
                    </div>
                </div>
    
                {{-- Form jika pilih Delivery --}}
                <div id="deliveryOptions" class="hidden mt-4">
                    <div class="flex w-full flex-col md:flex-row gap-4">
                        <div id="map" class="w-full h-72 rounded-lg z-0"></div>
                        <div class="w-full space-y-3">
                            <input type="text" name="latitude" id="latitude" class="hidden">
                            <input type="text" name="longitude" id="longitude" class="hidden">
                            <div class="w-full">
                                <div class="flex w-full justify-between items-center">
                                    <p class="text-sm text-gray-700 dark:text-gray-300">Alamat Tujuan <span class="font-thin">(Klik map)</span></p>
                                    <button id="infoButton" class="p-1 bg-gray-500 text-white rounded-full hover:bg-gray-600 text-xs flex items-center justify-center" style="width: 24px; height: 24px;">
                                        ?
                                    </button>
                                </div>
                                <input id="lokasi" name="lokasi" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Alamat pengiriman..." required>
                            </div>
                            <div class="w-full">
                                <p class="text-sm text-gray-700 dark:text-gray-300">Detail Lokasi <span class="font-thin">(Wajib)</span></p>
                                <input id="detail_lokasi" name="detail_lokasi" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Nama tempat / lantai / ruangan"></input>
                            </div>
                        </div>
                    </div>
                </div>
    
            </div>
    
            {{-- Produk yang dibeli --}}
            <div class="w-full mb-6" >
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Produk yang dipilih:</h2>
                
                <div class="space-y-4 overflow-y-auto" style="max-height: 400px;">
                    @forelse ($produks as $produk)
                        <div class="flex items-center gap-3 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow transition hover:bg-gray-200 dark:hover:bg-gray-600 order-item"> <!-- Added order-item class -->
                            <img src="{{ Storage::url('app/public/assets/'. $produk->foto) }}" alt="Produk Image" class="w-16 h-16 object-cover rounded-md shadow-md">
                            
                            <div class="ml-4 flex-1">
                                <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200">{{ $produk->nama_produk }}</h3>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Jumlah: {{ $produk->quantity }}</div>
                                <input type="number" class="hidden quantity-input w-16 mt-2" value="{{ $produk->quantity }}"> <!-- Added quantity input -->
                                <input type="hidden" class="id_produks" value="{{ $produk->id }}"> <!-- Assuming you have an id field -->
                            </div>
                            
                            <div class="text-right">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white price">Rp. {{ number_format($produk->price, 0, ',', '.') }}</h4> <!-- Correct price element -->
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-600 dark:text-gray-400 py-4">Keranjang kosong. Tambahkan produk sebelum checkout.</div>
                    @endforelse
                </div>
            </div>
            
            {{-- Catatan Pemesanan --}}
            <div class="w-full mb-6">
               <div class="flex gap-4 flex-col lg:flex-row mb-4">
                    <div class="w-full">
                        <label class="block text-sm font-medium text-gray-700" for="catatan">Catatan Pemesanan <span class="font-thin">(Optional)</span></label>
                        <input type="text" id="catatan" name="catatan" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm" required >
                    </div>
                </div>
            </div>
    
            {{-- Metode Pembayaran --}}
            <div class="w-full mb-6">
                <h1 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Pilih Pembayaran</h1>
                <select name="pembayaran" id="pembayaran" class="mt-2 block w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-600 dark:focus:ring-green-500 focus:border-green-600 dark:focus:border-green-500" required>
                    <option value="" disabled selected>Pilih Metode</option> 
                    <option value="Tunai">Tunai</option>
                </select>
            </div>
    
            {{-- Rincian Pembayaran --}}
            <div class="w-full mb-6">
                <h1 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Rincian Pembayaran</h1>
                
                <div class="w-full flex justify-between py-2">
                    <span class="text-gray-600 dark:text-gray-300">Total Pembelian</span>
                    <span class="text-gray-900 dark:text-gray-100 font-medium">
                        Rp {{ number_format(collect($produks)->sum(fn($p) => $p->price * $p->quantity), 0, ',', '.') }}
                    </span>
                </div>
                
                <div class="w-full flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-300">Biaya Penanganan</span>
                    <span id="biaya-penanganan" class="text-gray-900 dark:text-gray-100 font-medium">Rp 0</span> <!-- Set Biaya Penanganan value -->
                </div>
    
                <div class="w-full flex justify-between py-2">
                    <span class="font-bold text-gray-600 dark:text-gray-300">Total</span>
                    <span id="total-pembayaran" class="font-bold text-gray-900 dark:text-gray-100">
                        Rp {{ number_format(collect($produks)->sum(fn($p) => $p->price * $p->quantity), 0, ',', '.') }}
                    </span>
                </div>
            </div>
    
            {{-- Summary & Checkout Button --}}
            <div class="mt-8 flex justify-between items-center border-t pt-4 dark:border-gray-600">
                <h3 id="total-semua" class="text-xl font-semibold text-gray-800 dark:text-white">Total: Rp. {{ number_format(collect($produks)->sum(fn($p) => $p->price * $p->quantity), 0, ',', '.') }}</h3>
                
                <button id="submit-order" class="bg-green-700 hover:bg-green-800 transition duration-200 text-white font-medium rounded-lg px-6 py-2 focus:outline-none focus:ring-4 focus:ring-green-300 dark:focus:ring-green-800">
                    Check Out
                </button>
            </div>
        </form>
    </div>

    {{-- SWEAT ALERT SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    {{-- LEAFLET SCRIPT --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-geosearch@latest/dist/bundle.min.js"></script>
    
    <script>
        window.history.pushState(null, '', '{{ url()->current() }}');
        window.addEventListener('popstate', function (event) {
            // Use SweetAlert2 for confirmation dialog
            Swal.fire({
                title: 'Peringatan!',
                text: "Jika Anda kembali, data produk yang telah dipesan akan hilang. Apakah Anda yakin ingin melanjutkan?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, kembali',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Tidak, tetap di sini'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, go back to the previous page
                    history.back();
                } else {
                    // If not confirmed, push the current state again to prevent going back
                    window.history.pushState(null, '', '{{ url()->current() }}');
                }
            });
        });

        document.getElementById('infoButton').addEventListener('click', function() {
            Swal.fire({
                    title: 'Informasi',
                    text: 'Jika alamat tujuan tidak benar silahkan tambah detail tempatnya atau isi di bagian detail lokasi, tetap klik map lokasi tujuan!!!.',
                    icon: 'info',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
        });

        const provider = new GeoSearch.OpenStreetMapProvider();
        // Initialize the map centered at the given coordinates
        var map = L.map('map').setView([-7.717836, 109.018451], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        const search = new GeoSearch.GeoSearchControl({
            provider: new GeoSearch.OpenStreetMapProvider(),
            style: 'button',
        });

        map.addControl(search);

        // Inisialisasi marker
        let currentMarker;

        function getAddress(lat, lng) {
            // URL untuk Nominatim API
            const url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`;

            // Fetch alamat dari API
             // Fetch alamat dari API
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Mengambil informasi alamat yang diinginkan
                    if (data && data.address) {
                        const addressParts = [
                            data.address.amenity || '',
                            data.address.road || '',
                            data.address.suburb || '',
                            data.address.city || '',
                            data.address.postcode || ''
                        ].filter(part => part).join(', '); // Hanya ambil bagian yang ada dan gabungkan

                        // Mengisi input lokasi dengan bagian alamat
                        document.getElementById('lokasi').value = addressParts || ""; // Kosongkan jika tidak ada
                    } else {
                        // Kosongkan input jika tidak ada data alamat
                        document.getElementById('lokasi').value = ""; 
                    }

                    // Mengisi input latitude dan longitude
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                })
                .catch(error => {
                    console.error('Error fetching address:', error);
                    document.getElementById('lokasi').value = "Error fetching address"; // Atau bisa kosong
                });
        }

        // Event click pada peta
        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            // Jika marker sudah ada, hapus marker sebelumnya
            if (currentMarker) {
                map.removeLayer(currentMarker);
            }

            // Tambahkan marker baru di lokasi klik
            currentMarker = L.marker([lat, lng]).addTo(map)
                .bindPopup('Marker ditambahkan pada lokasi: <br> Latitude: ' + lat + '<br> Longitude: ' + lng)
                .openPopup();
            
            // Panggil fungsi untuk mendapatkan alamat
            getAddress(lat, lng);
        });

        // KONRTOL METODE 
        const deliveryMethodSelect = document.getElementById('metode');
        const pickupOptions = document.getElementById('pickupOptions');
        const deliveryOptions = document.getElementById('deliveryOptions');

        const inputJamAmbil = document.getElementById('jam_ambil');
        const inputLatitude = document.getElementById('latitude');
        const inputLangitude = document.getElementById('longitude');
        const inputAlamat = document.getElementById('lokasi');
        const inputDetail = document.getElementById('detail_lokasi');

        const biayaPenanganan = document.getElementById('biaya-penanganan');
        const totalPembayaran = document.getElementById('total-pembayaran');
        const totalSemua = document.getElementById('total-semua');
        const totalPembelian = {{ collect($produks)->sum(fn($p) => $p->price * $p->quantity) }};

        deliveryMethodSelect.addEventListener('change', function () {
            let biaya = 0

            if (this.value === 'PickUp') {
                pickupOptions.classList.remove('hidden');
                deliveryOptions.classList.add('hidden');
                inputLatitude.value = '';
                inputLangitude.value = '';
                inputAlamat.value = '';
                inputDetail.value = '';
                biaya = 2000;

                // Remove the marker when switching to PickUp
                if (currentMarker) {
                    map.removeLayer(currentMarker);
                    currentMarker = null; // Reset the marker variable
                }
            } else if (this.value === 'Delivery') {
                deliveryOptions.classList.remove('hidden');
                pickupOptions.classList.add('hidden');
                inputJamAmbil.value = '';
                biaya = 5000
            } else {
                pickupOptions.classList.add('hidden');
                deliveryOptions.classList.add('hidden');
            }

            biayaPenanganan.textContent = 'Rp ' + biaya.toLocaleString('id-ID');
            totalPembayaran.textContent = 'Rp ' + (totalPembelian + biaya).toLocaleString('id-ID');
            totalSemua.textContent = 'Rp ' + (totalPembelian + biaya).toLocaleString('id-ID');

        });

        // SUBMIT ORDER
        document.getElementById('submit-order').addEventListener('click', async (event) => {
            event.preventDefault(); // Prevent the default form submission

            const orderForm = document.getElementById('OrderForm');
            const formData = new FormData(orderForm); // Create a FormData object from the form

            // Validasi Form Pesanan
            const namaPemesan = document.getElementById('nama_pemesan').value.trim();
            const noTelp = document.getElementById('no_telp').value.trim();
            const pembayaran = document.querySelector('select[name="pembayaran"]').value;
            const pengantaran = document.querySelector('select[name="metode"]').value;
            
            if (!namaPemesan || !noTelp  || !pembayaran || !pengantaran) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Form Tidak Lengkap',
                    text: 'Mohon isi semua kolom yang diperlukan.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6',
                });
                return;
            }

            // Validasi Pengambilan Atau Detail Alamat
            if (pengantaran === "PickUp") {
                const jamAmbil = document.getElementById('jam_ambil').value.trim();
                if (!jamAmbil) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Jam Ambil Kosong',
                        text: 'Mohon isi jam ambil untuk pengambilan.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }
            }

            // Validasi untuk "Delivery"
            if (pengantaran === "Delivery") {
                const lokasi = document.getElementById('lokasi').value.trim();
                const detailLokasi = document.getElementById('detail_lokasi').value.trim();
                const latitude = document.getElementById('latitude').value.trim();
                const longitude = document.getElementById('longitude').value.trim();
                if (!lokasi  || !detailLokasi || !latitude || !longitude) {    
                    Swal.fire({
                        icon: 'warning',
                        title: 'Alamat Pengiriman Kosong',
                        text: 'Mohon isi alamat pengiriman.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }
            }

            // Validasi Pengambilan Atau Detail Alamat

            // Tampilkan konfirmasi sebelum melanjutkan
            const confirmation = await Swal.fire({
                title: 'Konfirmasi Order',
                text: 'Apakah Anda yakin ingin melakukan order ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Tidak',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            });

            // Jika pengguna memilih 'Tidak', hentikan eksekusi
            if (!confirmation.isConfirmed) {
                return;
            }

            // Show loading spinner using SweetAlert2
            Swal.fire({
                title: 'Proses Pesanan Sedang Berlangsung...',
                text: 'Mohon tunggu, pesanan Anda sedang diproses.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // DATA YANG DIKIRIM 
            // Data Detail Order
            const orderItems = [];
            const orderListItems = document.querySelectorAll('.order-item'); // Ensure this selector is correct

            Array.from(orderListItems).forEach(item => {
                const quantityElement = item.querySelector('.quantity-input');
                const priceElement = item.querySelector('.price');
                const idElement = item.querySelector('.id_produks');

                if (quantityElement && priceElement && idElement) {
                    const productId = idElement.value;
                    const quantity = parseInt(quantityElement.value, 10);

                    // Check if quantity is greater than 0
                    if (quantity > 0) {
                        const price = parseInt(priceElement.innerText.replace(/\D/g, ''), 10);
                        const subtotal = quantity * price;

                        orderItems.push({
                            product_id: productId,  
                            quantity: quantity,
                            price: price,
                            subtotal: subtotal
                        });
                    }
                }
            });

            // Log the order items for debugging purposes
            console.log(orderItems);

            // Data Order 
            const tanggalOrder = new Date().toISOString().slice(0, 10); // Get today's date in YYYY-MM-DD format
            const catatan = document.getElementById('catatan').value.trim();
            const IdOutlet = document.getElementById('IdOutlet').value; 
            const latitude = document.getElementById('latitude').value; 
            const longitude = document.getElementById('longitude').value; 
            const lokasi = document.getElementById('lokasi').value.trim();
            const detailLokasi = document.getElementById('detail_lokasi').value.trim();
            const jamAmbil = document.getElementById('jam_ambil').value.trim();

            // Calculate total quantity and total shopping cost
            const totalQty = orderItems.reduce((sum, item) => sum + item.quantity, 0);
            const totalBelanja = orderItems.reduce((sum, item) => sum + item.subtotal, 0);

            // Prepare the data to send to the server
            const orderData = {
                id_outlet: IdOutlet,
                nama_pemesan: namaPemesan,
                no_telp: noTelp,
                tanggal_order: tanggalOrder,
                lokasi: lokasi,
                detail_lokasi: detailLokasi,
                jam_ambil: jamAmbil,
                pembayaran: pembayaran,
                metode: pengantaran,
                latitude: latitude,
                longitude: longitude,
                catatan: catatan,
                total_barang: totalQty,
                total_belanja: totalBelanja,
                items: orderItems 
            };

            console.log(orderData);

            try {
                const response = await fetch('/ordering', {
                    method: 'POST', // Use POST method
                    body: JSON.stringify(orderData),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                });

                if (!response.ok) {
                    // Handle the error response
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Something went wrong');
                }

                const result = await response.json(); // Parse the JSON response

                // Show a success message or redirect
                Swal.fire({
                    icon: 'success',
                    title: 'Pesanan Berhasil',
                    text: 'Pesanan Anda telah berhasil diproses.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6',
                }).then(() => {
                    // Optionally redirect to a different page
                    window.location.href = `/waiting-order/${result.resi}`; // Change the URL as necessary
                });

            } catch (error) {
                // Handle any errors that occurred during the fetch
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6',
                });
            }
        });

        // BIKIN RESI 
        // function generateResi() {
        //     // Helper function to generate random letters
        //     function getRandomLetters(length) {
        //         const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        //         let result = '';
        //         for (let i = 0; i < length; i++) {
        //             result += letters.charAt(Math.floor(Math.random() * letters.length));
        //         }
        //         return result;
        //     }

        //     // Helper function to generate random digits
        //     function getRandomDigits(length) {
        //         const digits = '0123456789';
        //         let result = '';
        //         for (let i = 0; i < length; i++) {
        //             result += digits.charAt(Math.floor(Math.random() * digits.length));
        //         }
        //         return result;
        //     }

        //     // Get the current date
        //     const now = new Date();
        //     const year = now.getFullYear().toString().slice(-2); // Last two digits of the year
        //     const month = String(now.getMonth() + 1).padStart(2, '0'); // Zero-padded month

        //     // Format: LLMMYYLLDDDDD
        //     // LL - 2 random letters
        //     // MMYY - Current month and last two digits of the year
        //     // LL - 2 random letters
        //     // DDDDD - 5 random digits

        //     const resiNumber = `${getRandomLetters(2)}${month}${year}${getRandomLetters(2)}${getRandomDigits(5)}`;

        //     return resiNumber.toUpperCase(); // Ensure the result is in uppercase
        // }

        
    </script>
</x-layout>
