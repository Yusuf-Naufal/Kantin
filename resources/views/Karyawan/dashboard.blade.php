<x-karyawan-layout :title="$title">
    <x-karyawan-aside :outlet="$outlet"></x-karyawan-aside>
    <!-- Main content -->
    <div id="main-content" class="w-full transition-all duration-300">
        <x-karyawan-nav></x-karyawan-nav>
    
        <!-- Content -->
        <div class="h-max flex justify-center gap-2 md:w-full md:flex-row flex-col">
            <!-- Products Container -->
            <div style="min-width: 65%; height: fit-content;" class="md:min-w-[70%] w-full p-6 bg-white rounded-lg shadow-md mt-4 flex flex-col h-full">
                <div class="flex w-full flex-wrap justify-between items-center pb-5 border-b border-gray-700">
                    <h1 class="items-center font-semibold text-2xl">Produk</h1>
    
                    <div class="flex gap-3">
                        <div class="flex justify-center h-fit w-fit">
                            <button type="button" onclick="startCameraCode()" class="flex items-center justify-center p-3 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition duration-200">
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
                   @forelse($groupedProduks as $kategoriId => $produkGroup)
                        <h2 class="text-xl font-semibold text-purple-800 mt-4">
                            {{ $produkGroup->first()->Kategori->nama_kategori ?? 'Uncategorized' }} <!-- Menampilkan nama kategori -->
                        </h2>
                        
                        <div id="product-grid-{{ $kategoriId }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mt-2">
                            @forelse($produkGroup as $produk)
                                <button class="product-item relative flex flex-col bg-white rounded-lg shadow-md overflow-hidden
                                    {{ $produk->status === 'Habis' ? 'bg-gray-300 cursor-not-allowed' : 'hover:bg-gray-100' }}"
                                    data-name="{{ $produk->nama_produk }}"
                                    data-sku="{{ $produk->sku }}"
                                    data-id="{{ $produk->id }}"
                                    data-status="{{ $produk->status }}"
                                    onclick="{{ $produk->status !== 'Habis' ? 'addToOrder(\'' . $produk->id . '\', \'' . $produk->nama_produk . '\', \'' . number_format($produk->status === 'Diskon' ? $produk->harga_diskon : $produk->harga_jual, 0, ',', '.') . '\')' : '' }}">

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
                                        
                                        <p class="text-gray-600 text-sm font-semibold">
                                            @if($produk->status === 'Diskon')
                                                <!-- Display discounted price if applicable -->
                                                <span class="font-bold text-red-500">Rp. {{ number_format($produk->harga_diskon, 0, ',', '.') }}</span>
                                            @else
                                                <!-- Display regular price -->
                                                Rp. {{ number_format($produk->harga_jual, 0, ',', '.') }}
                                            @endif
                                        </p>
                                        <p class="hidden">{{ $produk->sku }}</p>
                                    </div>
                                </button>
                            @empty
                                <!-- Display a message when no products are available in this category -->
                                <p class="text-gray-500">Produk tidak tersedia dalam kategori ini.</p>
                            @endforelse
                        </div>
                    @empty
                        <!-- Display a message when no categories or products are found -->
                        <p class="text-gray-500">Tidak ada produk yang tersedia saat ini.</p>
                    @endforelse


                </div>
            </div>
    
            <!-- Order List -->
            <div style="min-width: 35%; height: fit-content;" class="w-full md:min-w-[30%] pt-5 pl-5 pr-5 pb-2 bg-white rounded-lg shadow-md mt-4 md:block flex flex-col h-auto">
                <div class="flex w-full justify-between items-center gap-4 pb-6 border-b border-gray-700">
                    <h1 class="items-center font-semibold text-2xl">Order</h1>
                    <input class="text-right max-w-48 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        type="text" name="" placeholder="Rp. " id="total-belanja" readonly disabled>
                </div>
                <div style="max-height: calc(100vh - 16rem);" id="order-list" class="flex-1 overflow-y-auto p-4 border-b border-gray-200 min-h-[calc(100vh-16rem)] max-h-[calc(100vh-16rem)]">
                    <!-- Order items will be added here -->
                </div> 
    
                <div class="flex gap-3 pb-3">
                    <button data-modal-target="default-modal" data-modal-toggle="default-modal" type="button" class="w-full mt-3 focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                        Bayar
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Main modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex justify-center items-center w-full h-[calc(200vh-1rem)] max-h-full bg-gray-900 bg-opacity-50">
        <div class="relative w-full max-w-5xl max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-800">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-6 border-b dark:border-gray-700 rounded-t-lg bg-gray-100 dark:bg-gray-700">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">
                        Pembayaran
                    </h3>
                    <button type="button" class="text-gray-500 hover:bg-gray-200 hover:text-gray-900 rounded-full p-2 dark:hover:bg-gray-700 dark:hover:text-white" data-modal-hide="default-modal">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6 flex flex-col md:flex-row gap-6">
                    <!-- Left Section (Order List) -->
                    <div class="w-full md:w-2/3 border-r border-gray-200 dark:border-gray-700 pr-4">
                        <div id="order-list-bayar" class="overflow-y-auto p-4 border-b border-gray-200 dark:border-gray-700 min-h-[calc(100vh-22rem)] max-h-[calc(100vh-22rem)]">
                            <!-- Order items will be added here -->
                        </div>
                        <div class="flex justify-between mt-6 text-lg font-medium dark:text-gray-300">
                            <span>Total (<span class="total-items">0</span> items)</span>
                            <span class="total-price">Rp. 0</span>
                        </div>
                    </div>

                    <!-- Right Section (Total and Payment) -->
                    <div class="w-full md:w-1/3">
                        <div class="bg-purple-600 p-1 rounded-lg text-center text-white">
                            <h1 class="text-3xl font-bold">TOTAL</h1>
                            <p id="total-bayar" class="text-2xl mt-2">Rp. 0</p>
                        </div>
                        <div class="mt-4 p-4 bg-white rounded-lg shadow-md space-y-4">
                            <div class="flex justify-between text-gray-800">
                                <label class="font-medium">No Resi</label>
                                <span id="resi-number" class="font-semibold"></span>
                            </div>
                            <div class="flex justify-between text-gray-800">
                                <label class="font-medium">Tanggal Transaksi</label>
                                <span id="current-date" class="font-semibold"></span>
                            </div>
                        </div>
                        <div class="mt-4 space-y-4">
                            <div class="relative">
                                <label for="nama_pembeli" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Pembeli</label>
                                <input type="text" name="nama_pembeli" id="nama_pembeli" class="text-right mt-1 block w-full px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 focus:border-purple-500 focus:ring-purple-500 dark:focus:border-purple-500 dark:focus:ring-purple-500 text-gray-900 dark:text-white" required>
                            </div>
                            <div class="flex gap-1 w-full">
                                <div class="relative w-full">
                                    <label for="kembali" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kembali</label>
                                    <input type="text" name="kembali" id="kembali" class="text-right mt-1 block w-full px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 focus:border-purple-500 focus:ring-purple-500 dark:focus:border-purple-500 dark:focus:ring-purple-500 text-gray-900 dark:text-white" readonly>
                                </div>
                                <div class="relative w-full">
                                    <label for="bayar" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bayar</label>
                                    <input type="number" name="bayar" id="bayar" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="text-right mt-1 block w-full px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 focus:border-purple-500 focus:ring-purple-500 dark:focus:border-purple-500 dark:focus:ring-purple-500 text-gray-900 dark:text-white" required>
                                </div>
                            </div>
                            <div class="relative">
                                <label for="catatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan</label>
                                <input type="text" name="catatan" id="catatan" class="text-right mt-1 block w-full px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 focus:border-purple-500 focus:ring-purple-500 dark:focus:border-purple-500 dark:focus:ring-purple-500 text-gray-900 dark:text-white" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="flex items-center p-6 border-t border-gray-200 dark:border-gray-700 rounded-b-lg bg-gray-100 dark:bg-gray-700">
                    <button id="submit-payment" type="button" class="w-full bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-lg px-6 py-3 text-white dark:focus:ring-green-800">
                        Bayar
                    </button>
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
        const IdOutlet = @json($outlet->id);
        function addToOrder(productId, productName, productPrice) {
            console.log('addToOrder called with:', productId, productName, productPrice);
            
            const orderList = document.getElementById('order-list');
            const totalBelanja = document.getElementById('total-belanja');
            const totalDisplay = document.querySelector('.total-price');
            const totalItemsLabel = document.querySelector('.total-items');
            const orderListBayar = document.getElementById('order-list-bayar');
            const totalBayar = document.getElementById('total-bayar');
            const bayarInput = document.getElementById('bayar');
            const kembaliInput = document.getElementById('kembali');

            if (!orderList || !totalBelanja || !totalDisplay || !totalItemsLabel || !orderListBayar || !totalBayar || !bayarInput || !kembaliInput) {
                console.error('Order list, total display, total items label, order list bayar, total bayar, bayar input, or kembali input element not found');
                return;
            }

            // UPDATE JUMLAH ITEM ORDER
            function updateQuantity(existingItem, quantity) {
                const quantityInput = existingItem.querySelector('.quantity-input');
                const priceLabel = existingItem.querySelector('.price');
                const pricePerItem = parseInt(productPrice.replace(/\D/g, ''));
                quantity = parseInt(quantity);

                if (quantity > 0) {
                    quantityInput.value = quantity;
                    const totalPrice = pricePerItem * quantity;
                    priceLabel.innerText = `Rp. ${totalPrice.toLocaleString()}`;
                } else {
                    removeItem(existingItem);
                }

                updateTotalPrice();
            }

            // HAPUS ITEM ORDER
            function removeItem(item) {
                item.remove();
                updateTotalPrice();
            }

            // UPDATE HARGA ITEM ORDER
            function updateTotalPrice() {
                let currentTotalPrice = 0;
                const orderItems = orderList.querySelectorAll('.price');

                orderItems.forEach(item => {
                    currentTotalPrice += parseInt(item.innerText.replace(/\D/g, ''));
                });

                totalBelanja.value = 'Rp. ' + currentTotalPrice.toLocaleString();
                totalDisplay.innerText = 'Rp. ' + currentTotalPrice.toLocaleString();
                totalBayar.innerText = 'Rp. ' + currentTotalPrice.toLocaleString();
                
                // Display fixed amount in order-list-bayar
                orderListBayar.innerHTML = '';
                orderList.querySelectorAll('.order-item').forEach(item => {
                    const clone = item.cloneNode(true);
                    clone.querySelector('.decrease-btn').remove();
                    clone.querySelector('.quantity-input').setAttribute('readonly', true);
                    orderListBayar.appendChild(clone);
                });

                let totalItems = 0;
                const quantities = orderList.querySelectorAll('.quantity-input');
                quantities.forEach(qty => {
                    totalItems += parseInt(qty.value);
                });
                totalItemsLabel.innerText = totalItems;
            }

            let existingItem = document.getElementById(`order-item-${productId}`);

            if (existingItem) {
                const quantityInput = existingItem.querySelector('.quantity-input');
                const newQuantity = parseInt(quantityInput.value) + 1;
                updateQuantity(existingItem, newQuantity);
            } else {
                const orderItem = document.createElement('div');
                orderItem.className = 'order-item flex gap-4 items-center mb-2'; 
                orderItem.id = `order-item-${productId}`;

                const itemContent = `
                    <div style="border-radius: 9999px; height: 2.25rem; width: 2.5rem; background-color: #4b5563; display: flex; justify-content: center; align-items: center; padding: 0.5rem; color: white;">
                        <label>${orderList.children.length + 1}</label>
                    </div>

                    <div class="w-full flex justify-between items-center">
                        <label>${productName}</label>
                        <div class="flex items-center gap-2">
                            <button class="decrease-btn bg-red-500 text-white px-2 rounded">-</button>
                            <input type="number" class="quantity-input p-1 border border-gray-300 rounded" value="1" min="1" style="width: 60px;">
                            <span class="price">Rp. ${productPrice}</span>
                        </div>
                    </div>
                `;
                orderItem.innerHTML = itemContent;
                orderList.appendChild(orderItem);

                const decreaseBtn = orderItem.querySelector('.decrease-btn');
                const quantityInput = orderItem.querySelector('.quantity-input');

                decreaseBtn.addEventListener('click', () => {
                    const newQuantity = parseInt(quantityInput.value) - 1;
                    updateQuantity(orderItem, newQuantity);
                });

                quantityInput.addEventListener('input', () => {
                    const newQuantity = parseInt(quantityInput.value);
                    updateQuantity(orderItem, newQuantity);
                });

                quantityInput.addEventListener('focus', () => {
                    quantityInput.select();
                });
            }

            updateTotalPrice();
        }

        // Handle pembayaran
        document.getElementById('bayar').addEventListener('input', () => {
            const totalBayarElement = document.getElementById('total-bayar');
            const totalBayarValue = parseInt(totalBayarElement.innerText.replace(/\D/g, '')) || 0;
            const bayarValue = parseInt(document.getElementById('bayar').value.replace(/\D/g, '')) || 0;
            const kembaliValue = bayarValue - totalBayarValue;

            if (kembaliValue < 0) {
                document.getElementById('kembali').value = 'Insufficient Amount';
            } else {
                document.getElementById('kembali').value = 'Rp. ' + kembaliValue.toLocaleString();
            }
        });

        // SCRIPT UNTUK KAMERA 
        var mediaStream = null;
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


        window.onload = function() {
            const totalBelanja = document.getElementById('total-belanja');
            const Bayar = document.getElementById('bayar');
            const Search = document.getElementById('simple-search');
            const Catatan = document.getElementById('catatan');
            const Pembeli = document.getElementById('nama_pembeli');
            const Kembali = document.getElementById('kembali');
            
            Bayar.value = '';
            Kembali.value = '';
            Search.value = '';
            Catatan.value = '';
            Pembeli.value = '';
            totalBelanja.value = 'Rp. 0';
        };

        // MEMBUAT RESI OTOMATIS
        function generateResi() {
            // Helper function to generate random letters
            function getRandomLetters(length) {
                const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                let result = '';
                for (let i = 0; i < length; i++) {
                    result += letters.charAt(Math.floor(Math.random() * letters.length));
                }
                return result;
            }

            // Helper function to generate random digits
            function getRandomDigits(length) {
                const digits = '0123456789';
                let result = '';
                for (let i = 0; i < length; i++) {
                    result += digits.charAt(Math.floor(Math.random() * digits.length));
                }
                return result;
            }

            // Get the current date
            const now = new Date();
            const year = now.getFullYear().toString().slice(-2); // Last two digits of the year
            const month = String(now.getMonth() + 1).padStart(2, '0'); // Zero-padded month

            // Format: LLMMYYLLDDDDD
            // LL - 2 random letters
            // MMYY - Current month and last two digits of the year
            // LL - 2 random letters
            // DDDDD - 5 random digits

            const resiNumber = `${getRandomLetters(2)}${month}${year}${getRandomLetters(2)}${getRandomDigits(5)}`;

            return resiNumber.toUpperCase(); // Ensure the result is in uppercase
        }

        // FORMAT TANGGAL
        function getCurrentDate() {
            const today = new Date();
            const day = String(today.getDate()).padStart(2, '0');
            const month = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
            const year = today.getFullYear();
            return `${day}/${month}/${year}`;
        }

        // PROSES TAMBAH TRANSAKSI
        document.getElementById('resi-number').innerText = generateResi();
        document.getElementById('current-date').innerText = getCurrentDate();
    
        document.getElementById('submit-payment').addEventListener('click', function() {
            const orderListItems = document.querySelectorAll('#order-list .order-item');
            const totalBayar = parseInt(document.getElementById('total-bayar').innerText.replace(/\D/g, ''));
            const bayar = parseInt(document.getElementById('bayar').value);
            const nama_pembeli = document.getElementById('nama_pembeli').value;
            const catatan = document.getElementById('catatan').value;
            const kembaliInput = document.getElementById('kembali');
            const submitButton = document.getElementById('submit-payment');
            

            // Check if the order list is empty
            if (orderListItems.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Belum Ada Order',
                    text: 'Tidak ada item di dalam daftar pesanan.',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (bayar >= totalBayar) {
                const resiNumber = generateResi(); // Function to generate receipt number
                document.getElementById('resi-number').innerText = resiNumber;
                document.getElementById('current-date').innerText = new Date().toLocaleDateString('id-ID');
                
                // Calculate change
                const kembali = bayar - totalBayar;
                kembaliInput.value = `Rp. ${kembali.toLocaleString()}`;

                // Collect order data
                const orderItems = [];
                document.querySelectorAll('#order-list .order-item').forEach(item => {
                    const productId = item.id.replace('order-item-', '');
                    const quantity = parseInt(item.querySelector('.quantity-input').value);
                    const price = parseInt(item.querySelector('.price').innerText.replace(/\D/g, ''));
                    orderItems.push({
                        productId: productId,
                        jumlah_barang: quantity,
                        subtotal: price
                    });
                });

                // Show loading spinner
                Swal.fire({
                    title: 'Memproses Pembayaran...',
                    text: 'Mohon tunggu, pembayaran sedang diproses.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading(); // Display loading spinner
                    }
                });

                // Disable submit button to prevent multiple clicks
                submitButton.disabled = true;

                // Send data to the server
                fetch('/transaksi', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        resi: resiNumber,
                        tanggal_transaksi: new Date().toISOString().slice(0, 10),
                        total_barang: document.querySelector('.total-items').innerText,
                        total_belanja: totalBayar,
                        id_outlet: IdOutlet,
                        nama_pembeli: nama_pembeli,
                        catatan: catatan,
                        status: bayar >= totalBayar ? 'Selesai' : 'Belum Selesai',
                        orderItems: orderItems
                    })
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    if (data.message) {
                        // Use SweetAlert to show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Transaksi Berhasil',
                            text: 'Terima kasih, transaksi Anda telah berhasil!',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Reload the page after user clicks OK
                            window.location.reload();
                        });
                    }
                })
                .catch(error => {
                    console.error('Error saving transaction:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Transaksi Gagal',
                        text: 'Gagal melakukan transaksi. Silakan coba lagi.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6',
                    });
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Uang Kurang!',
                    text: 'Jumlah bayar tidak mencukupi total belanja.',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'

                });
            }
        });

    </script>

    
</x-karyawan-layout>
