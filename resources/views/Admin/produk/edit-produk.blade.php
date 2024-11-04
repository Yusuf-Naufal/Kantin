<x-admin-layout>
    <div class="w-full p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Produk</h1>

        <form id="outlet-form" action="{{ route('produks.update',$produk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Card Container -->
            <div class="bg-white h-auto w-full shadow-md rounded-lg p-6">
                <div class="flex flex-wrap gap-4">
                    <div class="flex w-full gap-4 flex-col lg:flex-row items-center" >
                        <div>
                            <!-- Upload Image Section -->
                            <div class="flex items-center justify-center w-64 h-64">
                                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-full border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div id="image-preview" class="flex items-center justify-center w-full h-full hidden">
                                        <!-- Default SVG Icon -->
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                    </div>
                                    <input id="dropzone-file" type="file" class="hidden" accept="image/*"  name="foto" onchange="previewImage(event)" />
                                    <img class="w-full h-full rounded-md" id="image-update" src="{{ asset('public/assets/'. $produk->foto) }}" alt="">
                                </label>
                            </div>

                            <div class="flex justify-center mt-5">
                                <button type="button" onclick="startCamera()" class="flex items-center justify-center p-3 bg-blue-500 text-white rounded-full hover:bg-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera" viewBox="0 0 16 16">
                                        <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4z"/>
                                        <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5m0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7M3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="w-full">
                            <!-- Form Fields -->
                            <div class="mb-4 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="nama_produk">Nama Produk</label>
                                <input type="text" value="{{ $produk->nama_produk }}" id="nama_produk" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="nama_produk">
                            </div>

                            <div class="flex gap-4 ">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700" for="sku">SKU <span class="font-thin text-gray-600">(Max 13 Karakter)</label>
                                    <div class="relative">
                                        <input type="text" value="{{ $produk->sku }}" id="sku" maxlength="13" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="sku">
                                        <button type="button" onclick="checkSku()" class="absolute inset-y-0 right-0 flex items-center px-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M10.5 2c.58 0 1.15.058 1.699.17a1 1 0 1 1-.398 1.96a6.5 6.5 0 1 0 5.069 7.671a1 1 0 1 1 1.96.398a8.5 8.5 0 0 1-1.457 3.303l-.197.26l3.652 3.652a1 1 0 0 1-1.32 1.498l-.094-.084l-3.652-3.652A8.5 8.5 0 1 1 10.5 2M19 1a1 1 0 0 1 .898.56l.048.117l.13.378a3 3 0 0 0 1.684 1.8l.185.07l.378.129a1 1 0 0 1 .118 1.844l-.118.048l-.378.13a3 3 0 0 0-1.8 1.684l-.07.185l-.129.378a1 1 0 0 1-1.844.117l-.048-.117l-.13-.378a3 3 0 0 0-1.684-1.8l-.185-.07l-.378-.129a1 1 0 0 1-.118-1.844l.118-.048l.378-.13a3 3 0 0 0 1.8-1.684l.07-.185l.129-.378A1 1 0 0 1 19 1m0 3.196a5 5 0 0 1-.804.804q.448.355.804.804q.355-.448.804-.804A5 5 0 0 1 19 4.196"/></g></svg>
                                        </button>
                                    </div>
                                </div>
                                {{-- <button>Scan Barcode</button> --}}
                                <div class="flex justify-center mt-6 h-fit w-fit">
                                    <button type="button" onclick="startCameraCode()" class="flex items-center justify-center p-3 bg-blue-500 text-white rounded-full hover:bg-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera" viewBox="0 0 16 16">
                                            <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4z"/>
                                            <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5m0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7M3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="flex gap-4 flex-col lg:flex-row mb-4">
                                <div class="w-full md:w-1/3">
                                    <label for="id_kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                                    <div class="relative mt-1">
                                        <select id="id_kategori" name="id_kategori" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm appearance-none">
                                            <option value="" disabled {{ !$produk->id_kategori ? 'selected' : '' }}>Pilih Kategori</option>
                                            @foreach ($Kategori as $kategori)
                                                <option value="{{ $kategori->id }}" {{ $kategori->id == $produk->id_kategori ? 'selected' : '' }}>
                                                    {{ $kategori->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <!-- Button to trigger modal -->
                                        <button id="tambah-kategori-btn" type="button" data-modal-target="kategori-modal" data-modal-toggle="kategori-modal" class="mt-2 text-blue-600 font-thin">
                                            + Tambah Kategori
                                        </button>
                                    </div>
                                </div>
                                <div class="w-full md:w-1/3">
                                    <label class="block text-sm font-medium text-gray-700" for="id_unit">Unit</label>
                                    <div class="relative mt-1">
                                        <select id="id_unit" name="id_unit" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" >
                                            <option value="" disabled {{ !$produk->id_unit ? 'selected' : '' }}>Pilih Kategori</option>
                                            @foreach ($Unit as $unit )
                                            <option value="{{ $unit->id }}" {{ $unit->id == $produk->id_unit ? 'selected' : '' }}>
                                                {{ $unit->nama_unit }}</option>
                                            @endforeach  
                                        </select>

                                        <!-- Button to trigger modal -->
                                        <button id="tambah-unit-btn" type="button" data-modal-target="unit-modal" data-modal-toggle="unit-modal" class="mt-2 text-blue-600 font-thin">
                                            + Tambah Unit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white h-auto w-full shadow-md rounded-lg p-6 flex mt-4 flex-col lg:flex-row">
                <div class="w-full md:w-1/2 flex-col lg:flex-row">
                    <h1 class="text-2xl font-semibold">Informasi Produk</h1>
                    <div class="flex w-full pr-7 gap-3 mt-4 flex-col lg:flex-row" >
                        <div class="w-full md:w-1/2 mb-4">
                            <label class="block text-sm font-medium text-gray-700" for="stok_awal">Stok awal</label>
                            <input type="text" value="{{ $produk->stok_awal }}" id="stok_awal" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="stok_awal">
                        </div>
                        <div class="w-full md:w-1/2 mb-4">
                            <label class="block text-sm font-medium text-gray-700" for="stok_minimum">Stok Minimum</label>
                            <input type="text" value="{{ $produk->stok_minimum }}" id="stok_minimum" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="stok_minimum">
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 mb-4 pr-7">
                        <label class="block text-sm font-medium text-gray-700" for="harga_jual">Harga Jual</label>
                        <input type="text" value="{{ $produk->harga_jual }}" id="harga_jual" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="harga_jual">
                    </div>
                    <div class="w-full md:w-1/2 mb-4 pr-7">
                        <label class="block text-sm font-medium text-gray-700" for="harga_modal">Harga Modal</label>
                        <input type="text" value="{{ $produk->harga_modal }}" id="harga_modal" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="harga_modal">
                    </div>
                </div>
                <div class="w-full md:w-1/2 ">
                    <h1 class="text-2xl font-semibold">Informasi POS</h1>
                    
                    <!-- Checkbox untuk "Tersedia di POS" -->
                    <label class="flex items-center me-5 cursor-pointer my-4">
                        <input type="hidden" id="status" name="status" value="Habis">
                        <input type="checkbox" id="pos-toggle" class="sr-only peer" name="status-checkbox" {{ $produk->status == 'Aktif' ? 'checked' : '' }}/>
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                        <label for="pos-toggle" class="ms-2 text-xl font-semibold text-gray-900 dark:text-gray-300">Tersedia di POS</label>
                    </label>
                </div>

            </div>

            <div class="bg-white h-auto w-full shadow-md rounded-lg p-6 mt-4">
                <h1 class="text-2xl font-semibold mb-4">Catatan Produk</h1>

                <textarea id="wysiwyg-editor" name="catatan" class="w-full h-60 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ $produk->catatan }}</textarea>

            </div>

            <!-- Button Container -->
            <div class="w-full flex justify-end mt-4">
                <div>
                    <a href="{{ route('produks.index') }}" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                        Batal
                    </a>
                    <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                        Ubah
                    </button>
                </div>
            </div>
        </form>

        <!-- Modal Gambar -->
        <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center flex items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Ambil Gambar
                        </h3>
                        <button type="button" onclick="closeModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <div id="container" class="w-full">
                            <video autoplay="true" id="simplevideo" class="w-full h-64"></video>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide="default-modal" onclick="takeSnapshot()" type="button" class="mt-2 p-2 bg-green-500 text-white rounded">Capture</button>
                        <button data-modal-hide="default-modal" onclick="closeModal()" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
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

        <!-- Modal Kategori -->
        <div id="kategori-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <form action="{{ route('produks-kategori.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Tambah Kategori
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="kategori-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 space-y-4">
                            <div class="w-full rounded-md px-4">
                                <div class="mb-4 w-full">
                                    <label class="block text-sm font-medium text-gray-700" for="nama_kategori">Nama Kateogri</label>
                                    <input type="text" id="nama_kategori" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="nama_kategori">
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button data-modal-hide="kategori-modal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tambah</button>
                            <button data-modal-hide="kategori-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Unit -->
        <div id="unit-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <form action="{{ route('produks-unit.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Tambah Unit
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="unit-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 space-y-4">
                            <div class="w-full rounded-md px-4">
                                <div class="mb-4 w-full">
                                    <label class="block text-sm font-medium text-gray-700" for="nama_unit">Nama Unit</label>
                                    <input type="text" id="nama_unit" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="nama_unit">
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button data-modal-hide="unit-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Ubah</button>
                            <button data-modal-hide="unit-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- JavaScript for Image Preview -->
    <script>
        async function checkSku() {
            const skuInput = document.getElementById('sku').value;
            const skuPattern = /^[a-zA-Z0-9_-]+$/; // Adjust pattern as needed

            if (skuPattern.test(skuInput)) {
                // Show loading alert
                Swal.fire({
                    title: 'Checking...',
                    text: 'Harap Tunggu sebentar..',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                try {
                    const response = await fetch('/check-sku', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ sku: skuInput })
                    });

                    const result = await response.json();

                    // Close loading alert
                    Swal.close();

                    if (result.exists) {
                        Swal.fire({
                            icon: 'error',
                            title: 'SKU sudah ada!',
                            text: `SKU ${skuInput} sudah ada dalam database!`,
                            confirmButtonColor: '#3085d6',
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'SKU belum terdaftar!',
                            text: `SKU ${skuInput} belum terdaftar!`,
                            confirmButtonColor: '#3085d6',
                        });
                    }
                } catch (error) {
                    // Close loading alert on error
                    Swal.close();
                    console.error('Error checking SKU:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan!',
                        text: 'Gagal memeriksa SKU, silakan coba lagi.',
                        confirmButtonColor: '#3085d6',
                    });
                }
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'SKU tidak valid!',
                    text: `SKU ${skuInput} tidak valid! Silakan masukkan SKU yang valid.`,
                    confirmButtonColor: '#3085d6',
                });
            }
        }

        var mediaStream = null; // Store the media stream globally

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                document.getElementById('image-update').src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
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
        
        function startCameraCode() {
            // Show the modal
            document.getElementById('barcode-modal').classList.remove('hidden');

            // Initialize the QR code scanner
            function onScanSuccess(decodedText, decodedResult) {
                // Display the scanned result in the input field
                document.getElementById('sku').value = decodedText;
                console.log(`Code matched = ${decodedText}`, decodedResult);
                
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

        function takeSnapshot() {
            var video = document.querySelector("#simplevideo");
            var canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            var context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            var dataURL = canvas.toDataURL('image/png');

            document.getElementById('image-update').src = dataURL;

            // Create a file object and set it as the value of the file input
            var file = dataURLtoFile(dataURL, 'snapshot.png');
            var fileInput = document.getElementById('dropzone-file');
            var dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;

            // Hide the modal after capture
            closeModal();
        }

        function closeModal() {
            document.getElementById('default-modal').classList.add('hidden');
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

        // Helper function to convert dataURL to file
        function dataURLtoFile(dataURL, filename) {
            var arr = dataURL.split(','), mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
            while (n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }
            return new File([u8arr], filename, { type: mime });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const posToggle = document.getElementById('pos-toggle');
            const statusInput = document.getElementById('status');
            
            // Update the hidden status input based on the checkbox
            posToggle.addEventListener('change', function() {
                if (this.checked) {
                    statusInput.value = 'Aktif';
                } else {
                    statusInput.value = 'Habis';
                }
            });
        });


    </script>
</x-admin-layout>
