<x-layout :title="$title">
    <div style="max-width: 1300px;" class="w-full flex-col md:flex-wrap p-4 mb-10 mt-14 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-lg">

        {{-- KETERANGAN OUTLET --}}
        <div class="flex flex-col md:flex-row gap-6 rounded-lg p-3 border border-gray-200">
            <img class="w-full md:w-1/3 h-48 object-cover rounded-lg" src="{{ Storage::url('assets/'. $outlet->foto) }}" alt="Outlet">

            {{-- Detail Outlet --}}
            <div class="flex flex-col justify-between w-full">
                <div class="flex justify-between items-center mb-3">
                    <h1 class="font-bold text-2xl text-gray-800 truncate">{{ $outlet->nama_outlet }}</h1>
                    @if ($isOpen && $outlet->status === 'Aktif')
                        <span class="px-4 py-1 bg-green-500 items-center text-sm font-bold text-white rounded-full shadow-md transition transform hover:scale-105">
                            Buka
                        </span>
                    @else
                        <span class="px-4 py-1 bg-red-500 text-white text-sm font-bold rounded-full shadow-md transition transform hover:scale-105">
                            Tutup
                        </span>
                    @endif
                </div>

                <div class="space-y-3 text-gray-600">
                    {{-- Jam Operasional --}}
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="font-medium">Jam Operasional:</span>
                        <span class="text-gray-700 font-semibold">
                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $outlet->jam_buka)->format('H:i') }} - 
                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $outlet->jam_tutup)->format('H:i') }}
                        </span>
                    </div>

                    {{-- Jumlah Produk Outlet --}}
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="font-medium">Jumlah Produk:</span>
                        <span class="text-gray-700 font-semibold">{{ $JumlahProduk }} Produk</span>
                    </div>

                    {{-- Kontak Outlet --}}
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="font-medium">Kontak:</span>
                        <span class="text-gray-700 font-semibold">{{ $outlet->no_telp }}</span>
                    </div>

                    {{-- Alamat Outlet --}}
                    <div class="mt-4">
                        <span class="font-medium text-gray-500">Alamat:</span>
                        <p class="text-gray-700 leading-relaxed mt-1">
                            {{ $outlet->alamat }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- SEARCH PRODUK --}}
        <div class="w-full flex justify-end mt-5 -mb-10">
            <form class="relative w-full md:w-1/3 mb-4">
                <label for="produk-search" class="sr-only">Search</label>
                <input type="search" id="produk-search" class="w-full p-2 pl-10 text-sm border rounded-lg dark:bg-gray-700 focus:ring-blue-500" placeholder="Mau makan apa hari ini?" required>
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            </form>
        </div>

        {{-- PRODUK - PRODUK OUTLET --}}
        <div style="margin-top: -20px;">
            
            @forelse($groupedProduks as $kategoriId => $produkGroup)
            <div class="w-full mt-7">
                <h1 class="text-2xl font-bold mb-6 text-gray-800"> {{ $produkGroup->first()->Kategori->nama_kategori ?? 'Uncategorized' }}</h1>

                <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($produkGroup as $produk)
                        @if ($outlet->status === 'Aktif' && $isOpen)
                            {{-- Card Produk --}}
                            <div class="produk-card bg-white rounded-lg shadow-md border border-gray-200 p-4 relative">
                                {{-- Label Promo/Diskon/Habis --}}
                                @if($produk->status === 'Promo')
                                    <span class="absolute top-0 right-0 bg-orange-300 text-white text-xs font-semibold px-2 py-1 rounded z-10">Promo</span>
                                @elseif($produk->status === 'Diskon')
                                    <span class="absolute top-0 right-0 bg-red-600 text-white text-xs font-semibold px-2 py-1 rounded z-10">Diskon</span>
                                @elseif($produk->status === 'Habis')
                                    <span class="absolute top-0 right-0 bg-gray-500 text-white text-xs font-semibold px-2 py-1 rounded z-10">Habis</span>
                                @elseif($produk->status === 'Baru')
                                    <span class="absolute top-0 right-0 bg-blue-500 text-white text-xs font-semibold px-2 py-1 rounded z-10">Baru</span>
                                @endif

                                @if ($produk->status === 'Habis')
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="flex-1">
                                            <h2 class="font-semibold text-lg text-gray-600">{{ \Illuminate\Support\Str::limit($produk->nama_produk, 27) }}</h2>
                                            <p class="text-gray-500 text-sm mt-1">{{ \Illuminate\Support\Str::limit($produk->deskripsi, 65) }}</p>
                                            <p class="text-gray-400 font-bold text-lg mt-2">Rp. {{ number_format($produk->harga_jual, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <img src="{{ Storage::url('assets/'. $produk->foto) }}" alt="Produk" class="h-20 w-20 rounded-lg object-cover border border-gray-300 filter grayscale">
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center gap-1 text-gray-500">
                                            <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <!-- SVG Path here for the icon -->
                                            </svg>
                                            <span class="text-sm">{{ $produk->Kategori->nama_kategori }}</span>
                                        </div>

                                        {{-- Button Tambah (disabled if stok is 0 or product is "Habis") --}}
                                        <button type="button" 
                                                class="font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 bg-gray-400 text-gray-700 cursor-not-allowed disabled">
                                            Tambah
                                        </button>
                                    </div>
                                @else
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="flex-1">
                                            <h2 class="product-name font-semibold text-lg text-gray-800">{{ \Illuminate\Support\Str::limit($produk->nama_produk, 27) }}</h2>
                                            <p class="product-description text-gray-600 text-sm mt-1">{{ \Illuminate\Support\Str::limit($produk->deskripsi, 65) }}</p>
                                            
                                            @if($produk->status === 'Diskon' && $produk->harga_diskon)
                                                <p class="text-gray-500 line-through text-sm mt-2">Rp. {{ number_format($produk->harga_jual, 0, ',', '.') }}</p>
                                                <p class="text-red-600 font-bold text-lg ">Rp. {{ number_format($produk->harga_diskon, 0, ',', '.') }}</p>
                                            @else
                                                <p class="text-primary font-bold text-lg mt-2">Rp. {{ number_format($produk->harga_jual, 0, ',', '.') }}</p>
                                            @endif
                                        </div>
                                        <div class="flex-shrink-0">
                                            <img src="{{ Storage::url('assets/'. $produk->foto) }}" alt="Produk" class="h-20 w-20 rounded-lg object-cover border border-gray-300 {{ $produk->status === 'Habis' ? 'filter grayscale' : '' }}">
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center gap-1 text-gray-500">
                                            <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <!-- SVG Path here for the icon -->
                                            </svg>
                                            <span class="text-sm">{{ $produk->Kategori->nama_kategori }}</span>
                                        </div>

                                        {{-- Button Tambah --}}
                                        <div class="flex items-center space-x-2" id="product-controls-{{ $produk->id }}">
                                            <!-- Initial "Tambah" Button -->
                                            <button type="button" 
                                                    id="add-button-{{ $produk->id }}"
                                                    class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800"
                                                    onclick="addToCart({{ $produk->id }}, '{{ $produk->nama_produk }}', {{ $produk->status === 'Diskon' ? $produk->harga_diskon : $produk->harga_jual }})">
                                                Tambah
                                            </button>

                                            <!-- Quantity Control Elements - initially hidden -->
                                            <div id="quantity-controls-{{ $produk->id }}" class="flex items-center space-x-2 mt-1 hidden">
                                                <button onclick="changeQuantity({{ $produk->id }}, -1)" class="text-gray-900 font-semibold px-2 py-1 bg-gray-200 rounded">-</button>
                                                <span id="quantity-{{ $produk->id }}" class="text-gray-500">1</span>
                                                <button onclick="changeQuantity({{ $produk->id }}, 1)" class="text-gray-900 font-semibold px-2 py-1 bg-gray-200 rounded">+</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            {{-- Outlet tidak aktif atau tutup --}}
                            <div class="bg-gray-200 rounded-lg shadow-md border border-gray-300 p-4 relative opacity-50">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="flex-1">
                                        <h2 class="font-semibold text-lg text-gray-600">{{ \Illuminate\Support\Str::limit($produk->nama_produk, 27) }}</h2>
                                        <p class="text-gray-500 text-sm mt-1">{{ \Illuminate\Support\Str::limit($produk->deskripsi, 65) }}</p>
                                        <p class="text-gray-400 font-bold text-lg mt-2">Rp. {{ number_format($produk->harga_jual, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <img src="{{ Storage::url('assets/'. $produk->foto) }}" alt="Produk" class="h-20 w-20 rounded-lg object-cover border border-gray-300 filter grayscale">
                                    </div>
                                </div>
                            </div>
                        @endif
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

    </div>

    {{-- CHECK OUT BUTTON --}}
    <div id="checkout" class="hidden fixed w-full bottom-0 left-0 right-0 bg-white flex p-1 shadow-lg z-50 justify-center items-center">
        <div style="max-width: 700px;" class="w-full rounded-lg p-2 flex justify-between bg-green-500 items-center">
            <h1 id="item-count" class="text-white text-base font-semibold">0 Items</h1>
            <div class="flex items-center gap-2">
                <h1 id="total-price" class="text-white text-base font-semibold">Rp. 0</h1>
                <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="bg-white text-green-500 font-semibold rounded-full px-3 py-2 transition-colors duration-300 hover:bg-green-600 hover:text-white shadow-md" onclick="showCartModal()">
                    <!-- Cart Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M8.75 13a.75.75 0 0 0-1.5 0v4a.75.75 0 0 0 1.5 0zm7.25-.75a.75.75 0 0 1 .75.75v4a.75.75 0 0 1-1.5 0v-4a.75.75 0 0 1 .75-.75m-3.25.75a.75.75 0 0 0-1.5 0v4a.75.75 0 0 0 1.5 0z"/>
                        <path fill="currentColor" fill-rule="evenodd" d="M17.274 3.473c-.476-.186-1.009-.217-1.692-.222A1.75 1.75 0 0 0 14 2.25h-4a1.75 1.75 0 0 0-1.582 1c-.684.006-1.216.037-1.692.223A3.25 3.25 0 0 0 5.3 4.563c-.367.493-.54 1.127-.776 1.998l-.628 2.303a3 3 0 0 0-1.01.828c-.622.797-.732 1.746-.621 2.834c.107 1.056.44 2.386.856 4.05l.026.107c.264 1.052.477 1.907.731 2.574c.265.696.602 1.266 1.156 1.699c.555.433 1.19.62 1.929.71c.708.084 1.59.084 2.675.084h4.724c1.085 0 1.966 0 2.675-.085c.74-.088 1.374-.276 1.928-.71c.555-.432.891-1.002 1.156-1.698c.255-.667.468-1.522.731-2.575l.027-.105c.416-1.665.748-2.995.856-4.05c.11-1.09 0-2.038-.622-2.835a3 3 0 0 0-1.009-.828l-.628-2.303c-.237-.871-.41-1.505-.776-1.999a3.25 3.25 0 0 0-1.426-1.089M7.272 4.87c.22-.086.486-.111 1.147-.118c.282.59.884.998 1.58.998h4c.698 0 1.3-.408 1.582-.998c.661.007.927.032 1.147.118c.306.12.572.323.768.587c.176.237.279.568.57 1.635l.354 1.297c-1.038-.139-2.378-.139-4.043-.139H9.622c-1.664 0-3.004 0-4.042.139l.354-1.297c.29-1.067.394-1.398.57-1.635a1.75 1.75 0 0 1 .768-.587M10 3.75a.25.25 0 0 0 0 .5h4a.25.25 0 1 0 0-.5zm-5.931 6.865c.279-.357.72-.597 1.63-.729c.931-.134 2.193-.136 3.986-.136h4.63c1.793 0 3.054.002 3.985.136c.911.132 1.352.372 1.631.73c.279.357.405.842.311 1.758c-.095.936-.399 2.16-.834 3.9c-.277 1.108-.47 1.876-.688 2.45c-.212.554-.419.847-.678 1.05c-.259.202-.594.331-1.183.402c-.61.073-1.4.074-2.544.074h-4.63c-1.144 0-1.935-.001-2.544-.074c-.59-.07-.924-.2-1.183-.402c-.26-.203-.467-.496-.678-1.05c-.218-.574-.411-1.342-.689-2.45c-.434-1.74-.739-2.964-.834-3.9c-.093-.916.033-1.402.312-1.759" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>


    <!-- MODAL CART -->
    <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Produk yang dibeli</h3>
                    <button onclick="hideCartModal()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal" onclick="hideCartModal()">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                {{-- PRODUK APA SAJA YANG DIBELI --}}
                <div class="p-4 md:p-5 space-y-4 overflow-y-auto h-72" id="modal-cart-content">
                    <!-- Product items will be displayed here -->
                </div>

                <div class="items-center justify-center p-2 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <div class="flex justify-between w-full mb-2">
                        <h1>Total Harga</h1>
                        <h2 id="modal-total-price" class="font-bold">Rp. 0</h2>
                    </div>
                    <button type="button" id="checkout-button"
                    class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    Check Out</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Include SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const products = []; // Store selected products

            // Function to add product to the cart
            function addToCart(id, name, price) {
                // Check if the product is already in the cart
                const existingProduct = products.find(product => product.id === id);
                
                if (existingProduct) {
                    // If product exists, increase the quantity
                    existingProduct.quantity++;
                } else {
                    // If not, add the product with quantity 1
                    const cartItem = { id, name, price, quantity: 1 };
                    products.push(cartItem);
                }

                // Hide the "Tambah" button and show quantity controls
                document.getElementById(`add-button-${id}`).style.display = 'none';
                document.getElementById(`quantity-controls-${id}`).classList.remove('hidden');

                // Update the quantity display
                updateQuantityDisplay(id);
                
                // Update total count and total price
                updateCartDisplay();
                updateCheckoutSummary();
            }

            // Function to update the displayed quantity
            function updateQuantityDisplay(id) {
                const quantityElement = document.getElementById(`quantity-${id}`);
                const existingProduct = products.find(product => product.id === id);
                if (existingProduct) {
                    quantityElement.textContent = existingProduct.quantity;
                }
            }

            // Update the cart display in the modal
            function updateCartDisplay() {
                const modalContent = document.getElementById('modal-cart-content');
                const totalPriceElement = document.getElementById('modal-total-price');
                const itemCountElement = document.getElementById('item-count');

                modalContent.innerHTML = ''; // Clear previous content
                let totalPrice = 0;

                products.forEach(item => {
                    modalContent.innerHTML += `<div class="flex justify-between items-center border-b pb-2 mb-2">
                        <div>
                            <p class="text-gray-900 font-semibold">${item.name}</p>
                            <div class="flex items-center space-x-2 mt-1">
                                <button onclick="changeQuantity(${item.id}, -1)" class="text-gray-900 font-semibold px-2 py-1 bg-gray-200 rounded">-</button>
                                <span class="text-gray-500">${item.quantity}</span>
                                <button onclick="changeQuantity(${item.id}, 1)" class="text-gray-900 font-semibold px-2 py-1 bg-gray-200 rounded">+</button>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-900 font-semibold">Rp. ${new Intl.NumberFormat('id-ID').format(item.price * item.quantity)}</p>
                        </div>
                    </div>`;
                    totalPrice += item.price * item.quantity; // Sum the prices for total
                });

                totalPriceElement.innerText = `Rp. ${new Intl.NumberFormat('id-ID').format(totalPrice)}`;
                itemCountElement.innerText = `${products.length} Items`;
            }

            // Change the quantity of a product
            function changeQuantity(id, delta) {
                const product = products.find(product => product.id === id);
                if (product) {
                    product.quantity += delta; // Change the quantity

                    if (product.quantity <= 0) {
                        products.splice(products.indexOf(product), 1); // Remove product if quantity is 0
                        // Show the "Tambah" button again
                        document.getElementById(`add-button-${id}`).style.display = 'inline-block';
                        // Hide quantity controls
                        document.getElementById(`quantity-controls-${id}`).classList.add('hidden');
                    } else {
                        // Update the quantity display
                        updateQuantityDisplay(id);
                    }
                }

                updateCartDisplay(); // Update displayed quantities and total price
                updateCheckoutSummary(); // Update checkout summary
            }

            // Hide the cart modal
            function hideCartModal() {
                document.getElementById('default-modal').classList.add('hidden');
            }

            // Show the cart modal
            function showCartModal() {
                document.getElementById('default-modal').classList.remove('hidden');
                updateCartDisplay(); // Render the cart content when modal is shown
            }

            // Update checkout summary (item count and total price)
            function updateCheckoutSummary() {
                const itemCount = products.reduce((sum, product) => sum + product.quantity, 0);
                const totalPrice = products.reduce((sum, product) => sum + (product.price * product.quantity), 0);

                document.getElementById('item-count').innerText = `${itemCount} Items`;
                document.getElementById('total-price').innerText = `Rp. ${new Intl.NumberFormat('id-ID').format(totalPrice)}`;
                document.getElementById('checkout').classList.toggle('hidden', itemCount === 0);
            }

            function proceedToCheckout() {
                if (products.length === 0) {
                    Swal.fire({
                        title: 'Keranjang Kosong',
                        text: 'Tambahkan produk sebelum checkout.',
                        icon: 'warning',
                        confirmButtonText: 'Ok',
                        customClass: {
                            confirmButton: 'bg-green-500 text-white', // Customize the confirm button
                        }
                    });
                    return;
                }

                const selectedProducts = products.map(item => ({
                    id: item.id,
                    name: item.name,
                    price: item.price,
                    quantity: item.quantity
                }));

                const outletId = {{ $outlet->id }};

                // Show loading spinner
                Swal.fire({
                    title: 'Memproses Order...',
                    text: 'Mohon tunggu, Order akan diproses.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading(); // Display loading spinner
                    }
                });

                fetch('/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ products: selectedProducts, id_outlet: outletId })
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close();

                    // Redirect to checkout page with a short identifier or a session ID
                    window.location.href = `/checkout/${data.sessionId}`;
                })
                .catch(error => console.error('Error:', error));
            }

            // Add event listener for checkout button
            document.getElementById('checkout-button').addEventListener('click', proceedToCheckout);

            // Expose the functions to the global scope
            window.addToCart = addToCart;
            window.showCartModal = showCartModal; // Expose showCartModal
            window.hideCartModal = hideCartModal; // Expose hideCartModal
            window.changeQuantity = changeQuantity; // Expose changeQuantity

            // Search Produk
            const searchInput = document.getElementById("produk-search");
            const productCards = document.querySelectorAll(".produk-card"); 

            searchInput.value = '';

            searchInput.addEventListener("input", function () {
                const searchTerm = searchInput.value.toLowerCase();

                productCards.forEach(card => {
                    const productName = card.querySelector(".product-name").textContent.toLowerCase();
                    const productDescription = card.querySelector(".product-description").textContent.toLowerCase();

                    if (productName.includes(searchTerm) || productDescription.includes(searchTerm)) {
                        card.style.display = "block";
                    } else {
                        card.style.display = "none";
                    }
                });
            });
        });
    </script>



</x-layout>