<x-karyawan-layout :title="$title">
    <x-karyawan-aside :outlet="$Outlet"></x-karyawan-aside>
    <!-- Main content -->
    <div id="main-content" class="w-full transition-all duration-300">
        <x-karyawan-nav></x-karyawan-nav>

        <!-- Content -->
        <div class="h-max flex justify-center gap-2 md:w-full md:flex-row flex-col">
            <!-- Products Container -->
            <div style="min-width: 65%; height: fit-content;" class="md:min-w-[70%] w-full p-6 bg-white rounded-lg shadow-md mt-4 flex flex-wrap">
                <div class="flex w-full justify-between items-center pb-5 border-b border-gray-700">
                    <h1 class="items-center font-semibold text-2xl">Stok Produk</h1>

                    <div class="flex gap-3">
                        {{-- <button>Scan Barcode</button> --}}
                        <div class="flex justify-center h-fit w-fit">
                            <button type="button" onclick="startCameraCode()" class="flex items-center justify-center p-3 bg-blue-500 text-white rounded-full hover:bg-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera" viewBox="0 0 16 16">
                                    <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4z"/>
                                    <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5m0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7M3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0"/>
                                </svg>
                            </button>
                        </div>
                        <div class="w-auto md:w-96 md:min-w-80">
                            <div class="flex items-center max-w-sm mx-auto">
                                <label for="simple-search" class="sr-only">Search</label>
                                <div class="relative w-full">
                                    <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search produk name..." required />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scrollable Products Container -->
                <div style="max-height: calc(100vh - 13rem);" class="flex-1 overflow-y-auto p-4 border-b border-gray-200">
                    <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                        @forelse($Produk as $produk)
                            <button class="product-item flex flex-col bg-white rounded-lg shadow-md overflow-hidden"
                                data-name="{{ $produk->nama_produk }}"
                                data-sku="{{ $produk->sku }}"
                                data-status="{{ $produk->status }}"
                                data-id="{{ $produk->id }}"
                                onclick="addToDetail('{{ $produk->id }}', '{{ $produk->nama_produk }}')">
                                <div style="height: 128px" class="relative w-full h-32 bg-white items-center flex justify-center">
                                    <img src="{{ Storage::url('app/public/assets/' . $produk->foto) }}" class="w-full h-full object-contain">
                                    
                                    @if($produk->status === 'Habis')
                                    <!-- Watermark for "Habis" -->
                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                        <span class="text-white text-lg font-bold">Habis</span>
                                    </div>
                                    @elseif($produk->status === 'Promo')
                                    <!-- Label for Promo -->
                                    <div class="absolute top-0 left-0 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-br-lg rounded-tl-lg">
                                        Promo
                                    </div>
                                    @elseif($produk->status === 'Diskon')
                                    <!-- Label for Diskon -->
                                    <div class="absolute top-0 left-0 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-br-lg rounded-tl-lg">
                                        Diskon
                                    </div>
                                    @endif
                                </div>
                                <div class="p-4 flex flex-col items-start justify-start">
                                    <h2 class="text-sm text-left font-light text-gray-800 mb-2">{{ $produk->nama_produk }}</h2>
                                    <p class="text-gray-600 text-sm font-semibold">{{ number_format($produk->harga_jual, 0, ',', '.') }}</p>
                                    <p class="hidden">{{ $produk->sku }}</p>
                                </div>
                            </button>
                        @empty
                            <!-- Display a message when no categories or products are found -->
                            <p class="text-gray-500">Tidak ada produk yang tersedia saat ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div style="min-width: 35%; max-height: calc(100vh - 6rem);" class="overflow-y-auto w-full md:min-w-[30%] pt-5 pl-5 pr-5 pb-2 bg-white rounded-lg shadow-md mt-4 md:block flex flex-col">
                <div class="flex w-full justify-center items-center gap-4 pb-8 border-b border-gray-700">
                    <h1 class="items-center font-semibold text-2xl">Detail Produk</h1>
                </div>
                <div id="detail-produk" class="flex-1 overflow-y-auto p-6 border-b border-gray-300 min-h-[calc(100vh-16rem)] max-h-[calc(100vh-16rem)] bg-white rounded-lg shadow-lg">
                    <!-- Product Image -->
                    <div id="detail-image" class="mb-6 w-full h-64 rounded-lg shadow-md bg-gray-100 flex justify-center items-center">
                        <!-- Image will be loaded here -->
                    </div>

                    <!-- Product Information -->
                    <div class="mb-4">
                        <div class="flex gap-4 items-center mb-3">
                            <span class="text-base font-semibold text-gray-600">Nama Produk:</span>
                            <h2 id="detail-name" class="text-xl font-bold text-gray-900 tracking-wide"></h2>
                        </div>
                        <div class="flex gap-4 items-center mb-3">
                            <span class="text-base font-semibold text-gray-600">SKU:</span>
                            <p id="detail-sku" class="text-gray-700"></p>
                        </div>
                        <div class="flex gap-4 items-center mb-3">
                            <span class="text-base font-semibold text-gray-600">Harga Jual:</span>
                            <p id="detail-price" class="text-green-600 font-semibold text-lg"></p>
                        </div>
                        <div class="flex gap-4 items-center mb-3">
                            <span class="text-base font-semibold text-gray-600">Stok Awal:</span>
                            <p id="detail-stok-awal" class="text-gray-700 text-md"></p>
                        </div>
                        <div class="flex gap-4 items-center mb-3">
                            <span class="text-base font-semibold text-gray-600">Stok Minimum:</span>
                            <p id="detail-stok-minimum" class="text-gray-700 text-md"></p>
                        </div>
                        <div class="flex gap-4 items-center">
                            <span class="text-base font-semibold text-gray-600">Status:</span>
                            <p id="detail-status" class="text-red-600 font-semibold text-md"></p>
                        </div>
                    </div>
                </div>

                <div id="status-btn" class="flex gap-3">
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Scan -->
    <div id="barcode-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center flex items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Scan code
                    </h3>
                    <button type="button" onclick="closeModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="barcode-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4 relative">
                    <div id="container" class="w-full">
                        <div class="w-full" id="reader"></div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="barcode-modal" onclick="closeModal()" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                </div>
            </div>
        </div>
    </div>

    {{-- SCAN BARCODE --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="html5-qrcode.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>

    <script>
        // MENAMPILKAN DETAIL PRODUK
        function addToDetail(id, name) {
            // Get product data from the clicked element
            const productItem = document.querySelector(`[data-id="${id}"]`);
            const productName = productItem.getAttribute('data-name');
            const productSku = productItem.getAttribute('data-sku');
            const productImageSrc = productItem.querySelector('img').getAttribute('src');
            const productPrice = productItem.querySelector('.text-gray-600').innerText;
            
            // Assuming you have data attributes for stock values on the product button
            const productStokAwal = productItem.getAttribute('data-stok-awal');
            const productStokMinimum = productItem.getAttribute('data-stok-minimum');
            const productStatus = productItem.getAttribute('data-status');

            // Populate the detail section
            document.getElementById('detail-name').innerText = productName;
            document.getElementById('detail-sku').innerText = `${productSku}`;
            document.getElementById('detail-price').innerText = `Rp. ${productPrice}`;
            document.getElementById('detail-image').innerHTML = `<img src="${productImageSrc}" alt="${productName}" class="w-full h-64 object-contain rounded-lg shadow">`;
            
            // Update stock values
            document.getElementById('detail-stok-awal').innerText = productStokAwal;
            document.getElementById('detail-stok-minimum').innerText = productStokMinimum;
            document.getElementById('detail-status').innerText = productStatus;

            // Set the product ID on the buttons
            const statusBtnContainer = document.getElementById('status-btn');
            statusBtnContainer.innerHTML = ''; // Clear existing buttons

            if (productStatus === 'Habis') {
                statusBtnContainer.innerHTML = `
                    <button id="stock-activate-btn" data-product-id="${id}" type="button" class="w-full mt-3 focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">
                        Aktifkan
                    </button>
                `;
            } else {
                statusBtnContainer.innerHTML = `
                    <button id="stock-absent-btn" data-product-id="${id}" type="button" class="w-full mt-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                        Stok Abis
                    </button>
                `;
            }

            addButtonEventListeners();
        }

        // AKTIF KAMERA
        var mediaStream = null;
        // scan barkode
        function startCameraCode() {
            // Show the modal
            document.getElementById('barcode-modal').classList.remove('hidden');

            // Initialize the QR code scanner
            function onScanSuccess(decodedText, decodedResult) {
                // Display the scanned result in the input field
                const searchInput = document.getElementById('simple-search');
                searchInput.value = decodedText;
                console.log(`Code matched = ${decodedText}`, decodedResult);

                // Trigger input event to immediately filter products
                const event = new Event('input', { bubbles: true });
                searchInput.dispatchEvent(event);

                // Search for the product button using the decoded text (SKU or name)
                const productButton = document.querySelector(`.product-item[data-sku="${decodedText}"]`);

                // If product button is found, simulate a click on it
                if (productButton) {
                    productButton.click();
                } else {
                    console.error('Product not found for scanned code:', decodedText);
                }

                // Stop the scanner
                html5QrcodeScanner.clear().catch(err => {
                    console.error(`Failed to clear scanner: ${err}`);
                });

                // Stop the video stream
                const videoElement = document.querySelector("#reader video");
                if (videoElement && videoElement.srcObject) {
                    const stream = videoElement.srcObject;
                    const tracks = stream.getTracks();
                    tracks.forEach(track => track.stop());
                }

                // Close the modal after stopping the camera
                closeModal();
            }


            let config = {
                fps: 10,
                qrbox: { width: 500, height: 350 },
                rememberLastUsedCamera: true,
                supportedScanTypes: [
                    Html5QrcodeScanType.SCAN_TYPE_CAMERA,
                    Html5QrcodeScanType.SCAN_TYPE_FILE
                ]
            };

            let html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", config, /* verbose= */ false
            );
            html5QrcodeScanner.render(onScanSuccess);
        }

        function closeModal() {
            document.getElementById('barcode-modal').classList.add('hidden');

            // Stop the video stream
            if (mediaStream) {
                mediaStream.getTracks().forEach(track => track.stop());
                mediaStream = null;
            }
            // Stop the video stream
            const videoElement = document.querySelector("#reader video");
            if (videoElement && videoElement.srcObject) {
                const stream = videoElement.srcObject;
                const tracks = stream.getTracks();
                tracks.forEach(track => track.stop());
            }
            Quagga.stop();
        }

        function startCamera() {
            // Show the modal
            document.getElementById('default-modal').classList.remove('hidden');
            var video = document.querySelector("#simplevideo");

            // Start video stream
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(stream) {
                    mediaStream = stream; // Store the media stream
                    video.srcObject = stream;
                })
                .catch(function(err) {
                    console.error("Error accessing camera: ", err);
                    alert("Could not access camera. Please ensure you have granted permission.");
                });
        }

        // SEARCH PRODUK
        document.getElementById('simple-search').addEventListener('input', function() {
            const searchQuery = this.value.toLowerCase();
            const products = document.querySelectorAll('.product-item');
            
            products.forEach(function(product) {
                const productName = product.getAttribute('data-name').toLowerCase();
                const productSKU = product.getAttribute('data-sku').toLowerCase();
                
                // Check if the search query matches either the product name or SKU
                if (productName.includes(searchQuery) || productSKU.includes(searchQuery)) {
                    product.style.display = 'flex'; // Show the product if it matches
                } else {
                    product.style.display = 'none'; // Hide the product if it doesn't match
                }
            });
        });

        // UBAH STATUS BARANG
        function addButtonEventListeners() {
            const stockAbsentBtn = document.getElementById('stock-absent-btn');
            const stockActivateBtn = document.getElementById('stock-activate-btn');

            if (stockAbsentBtn) {
                stockAbsentBtn.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    
                    // Show SweetAlert confirmation for stock absence
                    Swal.fire({
                        title: 'Apakah stok habis?',
                        text: "Anda akan mengubah status stok menjadi habis!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Ya, habis!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // AJAX request to update the product status
                            fetch(`/produk/${productId}/update`, {
                                method: 'PATCH',  // Ensure this is PATCH
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    status: 'Habis'  // or 'Aktif' for the activate button
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Status Terupdate',
                                        text: 'Produk telah diubah statusnya menjadi Habis.',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: 'Gagal mengupdate status produk.',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error updating status:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Gagal melakukan permintaan. Silakan coba lagi.',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                });
                            });
                        }
                    });
                });
            }

            if (stockActivateBtn) {
                stockActivateBtn.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    
                    // Show SweetAlert confirmation for stock activation
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda ingin mengaktifkan kembali produk ini!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Aktifkan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // AJAX request to update the product status
                            fetch(`/produk/${productId}/update`, {
                                method: 'PATCH',  // Ensure this is PATCH
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    status: 'Aktif'  // or 'Aktif' for the activate button
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Status Terupdate',
                                        text: 'Produk telah diubah statusnya menjadi Aktif.',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: 'Gagal mengupdate status produk.',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error updating status:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Gagal melakukan permintaan. Silakan coba lagi.',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                });
                            });
                        }
                    });
                });
            }
        }



    </script>
    
</x-karyawan-layout>