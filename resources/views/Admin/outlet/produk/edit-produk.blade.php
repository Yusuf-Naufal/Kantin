<x-admin-layout :title="$title"> 
    <div class="w-full p-2">
        <h1 class="text-2xl font-bold mb-4">Edit Produk : {{ $produk->nama_produk }}</h1>

        <form id="outlet-form" action="{{ route('admin-update-produk-outlet', ['id' => $produk->id, 'uid' => $outlet->uid]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Card Container -->
            <div class="bg-white h-auto w-full shadow-md rounded-lg p-2">
                <div class="flex flex-wrap gap-4">
                    <div class="flex w-full gap-4 flex-col lg:flex-row items-center">
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
                                    <img class="w-full h-full rounded-md" id="image-update" src="{{ Storage::url('app/public/assets/' . $produk->foto) }}" alt="">
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
                                <input class="hidden" type="text" value="{{ $outlet->id }}" name="id_outlet" id="">
                                <input type="text" value="{{ $produk->nama_produk }}" id="nama_produk" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="nama_produk">
                            </div>

                            <div class="flex gap-4">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700" for="sku">SKU</label>
                                    <input type="text" value="{{ $produk->sku }}" id="sku" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="sku" placeholder="Generate Otomatis / Scan code">
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

                            <div class="flex gap-4 flex-col lg:flex-row">
                                <div class="w-full md:w-1/3">
                                    <label for="id_kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                                    <div class="relative mt-1">
                                        <select id="id_kategori" name="id_kategori" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm appearance-none">
                                            <option value="" disabled selected>Pilih Kategori</option>
                                            @foreach ($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}" {{ $kategori->id == $produk->id_kategori ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
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
                                        <select id="id_unit" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="id_unit">
                                            <option value="" disabled selected>Pilih Kategori</option>
                                            @foreach ($units as $unit )
                                            <option value="{{ $unit->id }}" {{ $unit->id == $produk->id_unit ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
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

            <div class="bg-white h-auto w-full shadow-md rounded-lg p-2 flex mt-4 flex-col lg:flex-row">
                <div class="w-full md:w-1/2">
                    <h1 class="text-2xl font-semibold">Informasi Produk</h1>
                    <div class="flex w-full pr-7 gap-3 mt-4 flex-col lg:flex-row">
                        <div class="w-full md:w-1/2 mb-4">
                            <label class="block text-sm font-medium text-gray-700" for="stok">Stok awal</label>
                            <input type="text" value="{{ $produk->stok }}" id="stok" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="stok">
                        </div>
                        <div class="w-full md:w-1/2 mb-4">
                            <label class="block text-sm font-medium text-gray-700" for="stok_minimum">Stok Minimum</label>
                            <input type="text" value="{{ $produk->stok_minimum }}" id="stok_minimum" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="stok_minimum">
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 mb-4 pr-7">
                        <label class="block text-sm font-medium text-gray-700" for="harga_jual">Harga Jual</label>
                        <input type="text" value="{{ $produk->harga_jual }}" id="harga_jual" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="harga_jual">
                    </div>
                    <div class="w-full md:w-1/2 mb-4 pr-7">
                        <label class="block text-sm font-medium text-gray-700" for="harga_modal">Harga Modal</label>
                        <input type="text" value="{{ $produk->harga_modal }}" id="harga_modal" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="harga_modal">
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <h1 class="text-2xl font-semibold">Informasi POS</h1>
                    
                    <div class="w-full mt-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status Produk</label>
                        <select name="status" id="status" onchange="handleStatusChange()" style="height: 41px;" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="" disabled selected>Pilih status</option>
                            <option value="Baru" {{ $produk->status === 'Baru' ? 'selected' : '' }}>Baru</option>
                            <option value="Aktif" {{ $produk->status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Habis" {{ $produk->status === 'Habis' ? 'selected' : '' }}>Habis</option>
                            <option value="Diskon" {{ $produk->status === 'Diskon' ? 'selected' : '' }}>Diskon</option>
                            <option value="Promo" {{ $produk->status === 'Promo' ? 'selected' : '' }}>Promo</option>
                        </select>
                    </div>

                    <div class="w-full flex flex-col md:flex-row gap-2 items-center">
                        <div class="w-full mt-4" id="diskon-produk" style="display: none;">
                             <label for="diskon" class="text-sm font-medium text-gray-700 flex">
                                Diskon Produk <span class="font-thin">(%)</span>
                                <span id="diskon-error" class="text-red-500 text-sm" style="display: none;">(Max 100)</span>
                            </label>
                            <input type="number" id="diskon" maxlength="3" pattern="[0-9]*" 
                                oninput="this.value=this.value.replace(/[^0-9]/g,'');" 
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 
                                        focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                name="diskon" onchange="hitungHargaDiskon()"
                                value="{{ $produk->diskon }}"> 
                        </div>

                        <div class="w-full mt-4" id="diskon-harga" style="display: none;">
                            <label for="" class="block text-sm font-medium text-gray-700">Harga Diskon <span class="font-thin">(pembulatan)</span></label>
                            <input type="number" value="{{ $produk->harga_diskon }}" id="harga-diskon" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="harga_diskon" readonly>
                        </div>
                    </div>


                </div>
            </div>

            <div class="bg-white h-auto w-full shadow-md rounded-lg p-2 mt-4">
                <h1 class="text-2xl font-semibold mb-4">Deskripsi Produk</h1>

                <textarea id="wysiwyg-editor" name="deskripsi" style="height: 240px;" class="w-full h-60 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" >{{ $produk->deskripsi }}</textarea>
            </div>

            <!-- Button Container -->
            <div class="w-full flex justify-end mt-4">
                <div>
                    <a href="{{ route('admin-all-produk-outlet', $outlet->uid) }}" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                        Batal
                    </a>
                    <button id="ubah-button" type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
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
                        <button data-modal-hide="default-modal" onclick="takeSnapshot()" type="button" class="p-2 bg-green-500 text-white rounded">Capture</button>
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
                <form action="{{ route('admin-produk-store-kategori', $outlet->uid) }}" method="POST" enctype="multipart/form-data">
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
                <form action="{{ route('admin-produk-store-unit', $outlet->uid) }}" method="POST" enctype="multipart/form-data">
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
                            <button data-modal-hide="unit-modal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tambah</button>
                            <button data-modal-hide="unit-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    {{-- SCAN BARCODE --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="html5-qrcode.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>

    <!-- SCRIPT -->
    <script>
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

            // Stop the video stream
            if (mediaStream) {
                mediaStream.getTracks().forEach(track => track.stop());
                mediaStream = null;
            }
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

        // SCAN BARKODE
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

        // STATUS KONTROL
        function handleStatusChange() {
            const statusSelect = document.getElementById('status');
            const diskonProduk = document.getElementById('diskon-produk');
            const diskonHarga = document.getElementById('diskon-harga');
            const diskonInput = document.getElementById('diskon');
            const hargaDiskon = document.getElementById('harga-diskon');

            // Check if the selected option is "Diskon"
            if (statusSelect.value === 'Diskon') {
                diskonProduk.style.display = 'block'; // Show diskon input
                diskonHarga.style.display = 'block'; // Show diskon input
            } else {
                diskonProduk.style.display = 'none'; // Hide diskon input
                diskonHarga.style.display = 'none'; // Hide diskon input
                diskonInput.value = null;
                hargaDiskon.value = null;
            }
        }

        // DISKON KONTROL
        document.addEventListener('DOMContentLoaded', function () {
            const diskonInput = document.getElementById('diskon');
            const hargaJualInput = document.getElementById('harga_jual');

            // Add event listeners to calculate the discounted price when user types
            diskonInput.addEventListener('input', hitungHargaDiskon);
            hargaJualInput.addEventListener('input', hitungHargaDiskon);
        });

        function hitungHargaDiskon() {
            const hargaJual = parseFloat(document.getElementById('harga_jual').value);
            let diskon = parseFloat(document.getElementById('diskon').value);
            const hargaDiskonInput = document.getElementById('harga-diskon');
            const errorMessage = document.getElementById('diskon-error');
            const tambahButton = document.getElementById('ubah-button');

            // Validate discount, ensuring it does not exceed 100
            if (diskon > 100) {
                errorMessage.style.display = 'block'; // Show error message
                diskon = 100; // Set diskon to 100 if it exceeds 100
                diskonInput.value = diskon; // Update diskon input value
                tambahButton.disabled = true;
            } else {
                errorMessage.style.display = 'none'; // Hide error message
                tambahButton.disabled = false;
            }
            
            // Ensure valid inputs for price and discount
            if (!isNaN(hargaJual) && !isNaN(diskon)) {
                // Calculate the price after discount
                let hargaSetelahDiskon = hargaJual * (1 - diskon / 100);

                // Round the price according to rules
                hargaSetelahDiskon = bulatkanHarga(hargaSetelahDiskon);

                // Display the result in the discounted price input
                hargaDiskonInput.value = hargaSetelahDiskon.toFixed(0); // Remove decimals
            } else {
                // If inputs are invalid, clear the discounted price
                hargaDiskonInput.value = '';
            }
        }

        function bulatkanHarga(nilai) {
            // Round the price to the nearest thousand or hundred
            let sisaRatusan = nilai % 1000;

            if (sisaRatusan > 0 && sisaRatusan <= 499) {
                return Math.floor(nilai / 1000) * 1000 + 500;
            } else if (sisaRatusan >= 501 && sisaRatusan <= 999) {
                return Math.ceil(nilai / 1000) * 1000;
            } else {
                return nilai;
            }
        }




    </script>
</x-admin-layout>
