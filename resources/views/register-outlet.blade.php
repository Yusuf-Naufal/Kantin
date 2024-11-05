<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Outlet</title>

    {{-- TAILWIND CSS  --}}
    {{-- @vite('resources/css/app.css') --}}

    <link rel="stylesheet" href="/build/assets/app-DMXIxZ_f.css">
    <link rel="stylesheet" href="/build/assets/app-CW2gkweu.css">

    {{-- FLOWBITE CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" />
</head>
<body class="w-full flex items-center justify-center bg-gray-100 p-2">
    <div class="w-full flex flex-col md:w-auto bg-white rounded-lg shadow-lg px-5 py-3">

        @if($status === 'pending')
            {{-- STATUS PENGAJUAN PENDING --}}
            <div id="status-user-berhasil" class="text-center md:max-w-sm">
                <h2 class="text-3xl font-bold text-green-400 mb-4">Pengajuan Berhasil!</h2>
                <div class="w-full items-center flex justify-center my-2">
                    <img src="{{ asset('public/assets/icon-outlet-pending.png') }}" alt="daftar-outlet">
                </div>
                <p class="text-gray-700 mb-6">
                    Status outlet Anda saat ini belum disetujui. Mohon tunggu persetujuan dari Admin.
                </p>
                <div class="flex gap-4 justify-center">
                    <a href="{{ route('home') }}" class="text-gray-700 bg-gray-100 border border-gray-300 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 font-semibold rounded-lg text-sm px-6 py-2 transition ease-in-out">
                        Kembali
                    </a>
                    <button type="button" class="bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg text-sm px-6 py-2 focus:outline-none focus:ring-2 focus:ring-green-400 transition ease-in-out">
                        Detail
                    </button>
                    
                </div>
            </div>

            {{-- DETAIL PENGAJUAN --}}

            <div id="detail-outlet" class="hidden md:w-full">
                <h2 class="text-3xl font-bold text-green-400 mb-4">Detail Pengajuan</h2>
                <div class="space-y-6">
                    <div class="flex gap-6 flex-col md:flex-row">
                        <div class="flex flex-col items-center w-auto h-64 md:w-64 md:h-64">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                <img class="w-full h-full rounded-md" id="image-update" src="{{ Storage::url('assets/' . $pengajuan->foto) }}" alt="">
                            </label>
                        </div>

                        <div class="flex-1 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="nama_outlet">Nama Outlet</label>
                                <input type="text" value="{{  $pengajuan->nama_outlet }}" id="nama_outlet" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="nama_outlet" readonly>
                            </div>

                            <div class="flex gap-4 flex-col md:flex-row">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700" for="no_telp">Telepon</label>
                                    <input type="text" value="{{  $pengajuan->no_telp }}" id="no_telp" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="no_telp" readonly>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                                    <input type="text" value="{{  $pengajuan->email }}" id="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="email" readonly>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700" for="pemilik">Pemilik</label>
                                    <input value="{{ auth()->user()->name }}" type="text" id="pemilik" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" readonly>
                                    <input type="text" name="id_user" id="" class="hidden" value="{{ auth()->user()->id }}">
                                </div>
                            </div>

                            <div class="flex gap-4 flex-col md:flex-row">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700" for="instagram">Instagram <label class="font-thin text-gray-500">(Opsional)</label></label>
                                    <input type="text" value="{{  $pengajuan->instagram }}" id="instagram" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="instagram" readonly>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700" for="facebook">Facebook <label class="font-thin text-gray-500">(Opsional)</label></label>
                                    <input type="text" id="facebook" value="{{ $pengajuan->facebook }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="facebook" readonly>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700" for="tiktok">Tiktok <label class="font-thin text-gray-500">(Opsional)</label></label>
                                    <input type="text" id="tiktok" value="{{  $pengajuan->tiktok }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="tiktok" readonly>
                                </div>
                            </div>

                            <div class="flex gap-4 flex-col lg:flex-row "> 
                                <div class="mb-4 w-full">
                                    <label class="block text-sm font-medium text-gray-700" for="jam_operasional">Jam Operasional</label>
                                    <div class="flex w-full items-center space-x-2">
                                        <input type="time" value="{{ $pengajuan->jam_buka }}" name="jam_buka" id="jam_buka" class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <span>-</span>
                                        <input type="time" value="{{ $pengajuan->jam_tutup }}" name="jam_tutup" id="jam_tutup" class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>
                                </div>


                                <div class="mb-4 w-full">
                                    <label class="block text-sm font-medium text-gray-700" for="pin">Pin <label class="font-thin text-gray-500">(4 Angka)</label>
                                    <input type="text" value="{{ $pengajuan->pin }}" id="pin" maxlength="4" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="pin" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="alamat">Alamat</label>
                            <input type="text" value="{{  $pengajuan->alamat }}" id="alamat" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="alamat" readonly>
                        </div>

                        <div class="mb-4 w-full">
                            <label class="block text-sm font-medium text-gray-700" for="deskripsi">Deskripsi Outlet</label>
                            <textarea id="deskripsi" 
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                name="deskripsi" rows="4" required>{{ $pengajuan->deskripsi }}</textarea>
                        </div>

                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('home') }}" class="text-gray-700 bg-gray-100 border border-gray-300 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 font-semibold rounded-lg text-sm px-6 py-2 transition ease-in-out">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

        @elseif ($status === 'rejected')

            {{-- STATUS PENGAJUAN PENDING --}}
            <div id="status-user-berhasil" class="text-center md:max-w-sm">
                <h2 class="text-3xl font-bold text-red-400 mb-4">Pengajuan Ditolak!</h2>
                <div class="w-full items-center flex justify-center my-2">
                    <img src="{{ asset('public/assets/icon-outlet-ditolak.png') }}" alt="daftar-outlet">
                </div>
                <p class="text-gray-700 mb-6">
                    Outlet yang anda ajukan ditolak. Silahkan Daftar dilain hari...
                </p>
                <div class="flex gap-4 justify-center">
                    <a href="{{ route('home') }}" class="text-gray-700 bg-gray-100 border border-gray-300 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 font-semibold rounded-lg text-sm px-6 py-2 transition ease-in-out">
                        Kembali
                    </a>
                </div>
            </div>

        @else

            {{-- CEK STATUS --}}
            <div id="status-user" class="text-center md:max-w-sm">
                
                <h2 class="text-3xl font-bold text-red-600 mb-4">Peringatan!</h2>
                <div class="w-full items-center flex justify-center my-2">
                    <img src="{{ asset('public/assets/icon-outlet-daftar.png') }}" alt="daftar-outlet">
                </div>
                <p class="text-gray-700 mb-6">
                    Anda belum terdaftar pada outlet manapun! Silakan mendaftar terlebih dahulu.
                </p>
                
                <div class="flex gap-4 justify-center">
                    <a href="/" class="text-gray-700 bg-gray-100 border border-gray-300 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 font-semibold rounded-lg text-sm px-6 py-2 transition ease-in-out">
                        Batal
                    </a>
                    <button type="button" class="bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg text-sm px-6 py-2 focus:outline-none focus:ring-2 focus:ring-green-400 transition ease-in-out">
                        Buat
                    </button>
                </div>
            </div>

            {{-- REGISTER OUTLET --}}
            <div id="outlet-register" class="hidden w-full top-0 ">
                <h1 class="text-3xl mb-3 font-semibold text-center md:text-left">PENGAJUAN OUTLET</h1>
                <form id="outlet-form" action="{{ route('pemilik-store-pengajuan-outlet') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-2">
                        <div class="flex w-full flex-col lg:flex-row items-center gap-4">
                            <div>
                                <!-- Upload Image Section -->
                                <div class="flex items-center justify-center w-64 h-64">
                                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-full border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                        <div id="image-preview" class="flex items-center justify-center w-full h-full">
                                            <!-- Default SVG Icon -->
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                        </div>
                                        <input id="dropzone-file" type="file" class="hidden" accept="image/*" name="foto" onchange="previewImage(event)" class="w-full"/>
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
                                    <label class="block text-sm font-medium text-gray-700" for="nama_outlet">Nama Outlet</label>
                                    <input type="text" id="nama_outlet" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="nama_outlet" required>
                                </div>

                                <div class="flex gap-4 flex-col lg:flex-row ">
                                    <div class="w-full md:w-1/3 mb-4">
                                        <label class="block text-sm font-medium text-gray-700" for="no_telp">Telepon <span class="font-thin text-gray-600">(Nomor outlet)</label>
                                        <input type="text" id="no_telp" maxlength="20" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="no_telp" required>
                                    </div>
                                    <div class="w-full md:w-1/3 mb-4">
                                        <label class="block text-sm font-medium text-gray-700" for="email">Email <span class="font-thin text-gray-600">(Email outlet)</label>
                                        <div class="relative">
                                                <input type="text" id="email" name="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 pr-12 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Email@example.com">
                                                <button type="button" onclick="checkEmail()" class="absolute inset-y-0 right-0 flex items-center px-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition-all">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M10.5 2c.58 0 1.15.058 1.699.17a1 1 0 1 1-.398 1.96a6.5 6.5 0 1 0 5.069 7.671a1 1 0 1 1 1.96.398a8.5 8.5 0 0 1-1.457 3.303l-.197.26l3.652 3.652a1 1 0 0 1-1.32 1.498l-.094-.084l-3.652-3.652A8.5 8.5 0 1 1 10.5 2M19 1a1 1 0 0 1 .898.56l.048.117l.13.378a3 3 0 0 0 1.684 1.8l.185.07l.378.129a1 1 0 0 1 .118 1.844l-.118.048l-.378.13a3 3 0 0 0-1.8 1.684l-.07.185l-.129.378a1 1 0 0 1-1.844.117l-.048-.117l-.13-.378a3 3 0 0 0-1.684-1.8l-.185-.07l-.378-.129a1 1 0 0 1-.118-1.844l.118-.048l.378-.13a3 3 0 0 0 1.8-1.684l.07-.185l.129-.378A1 1 0 0 1 19 1m0 3.196a5 5 0 0 1-.804.804q.448.355.804.804q.355-.448.804-.804A5 5 0 0 1 19 4.196"/></g></svg>
                                                </button>
                                            </div>
                                    </div>
                                    <div class="w-full md:w-1/3 mb-4">
                                        <label class="block text-sm font-medium text-gray-700" for="pemilik">Pemilik</label>
                                        <input value="{{ auth()->user()->name }}" type="text" id="pemilik" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" readonly>
                                        <input type="text" name="id_user" id="" class="hidden" value="{{ auth()->user()->id }}">
                                    </div>
                                </div>

                                <div class="flex gap-4 flex-col lg:flex-row ">
                                    <div class="w-full md:w-1/3 mb-4">
                                        <label class="block text-sm font-medium text-gray-700" for="instagram">Instagram <label class="font-thin text-gray-500">(Opsional)</label>
                                        <input type="text" id="instagram" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="instagram" placeholder="Username Instagram">
                                    </div>
                                    <div class="w-full md:w-1/3 mb-4">
                                        <label class="block text-sm font-medium text-gray-700" for="facebook">Facebook <label class="font-thin text-gray-500">(Opsional)</label>
                                        <input type="text" id="facebook" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="facebook" placeholder="Username Facebook">
                                    </div>
                                    <div class="w-full md:w-1/3 mb-4">
                                        <label class="block text-sm font-medium text-gray-700" for="tiktok">Tiktok <label class="font-thin text-gray-500">(Opsional)</label>
                                        <input type="text" id="tiktok" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="tiktok" placeholder="Username Tiktok">
                                    </div>
                                </div>

                                <div class="flex gap-4 flex-col lg:flex-row "> 
                                    <div class="mb-4 w-full">
                                        <label class="block text-sm font-medium text-gray-700" for="jam_operasional">Jam Operasional</label>
                                        <div class="flex w-full items-center space-x-2">
                                            <input type="time" name="jam_buka" id="jam_buka" class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <span>-</span>
                                            <input type="time" name="jam_tutup" id="jam_tutup" class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>
                                    </div>


                                    <div class="mb-4 w-full">
                                        <label class="block text-sm font-medium text-gray-700" for="pin">Pin <label class="font-thin text-gray-500">(4 Angka)</label>
                                        <input type="text" id="pin" maxlength="4" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="pin" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="alamat">Alamat</label>
                                <input type="text" id="alamat" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="alamat" required>
                            </div>

                            <div class="mb-4 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="deskripsi">Deskripsi Outlet</label>
                                <textarea id="deskripsi" 
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                    name="deskripsi" rows="4" required></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4">
                            <a id="kembali" class="text-gray-700 bg-gray-100 border border-gray-300 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 font-semibold rounded-lg text-sm px-6 py-2 transition ease-in-out">
                                Batal
                            </a>
                            <button id="daftar" type="button" class="bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg text-sm px-6 py-2 focus:outline-none focus:ring-2 focus:ring-green-400 transition ease-in-out">
                                Daftar
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        @endif


    </div>

    <!-- Main modal -->
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


    {{-- SWEETALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="/build/assets/app-CFG0kKgu.js "></script>

    <script>
        async function checkEmail() {
            const emailInput = document.getElementById('email').value;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; 

            if (emailPattern.test(emailInput)) {
                // Show loading alert
                Swal.fire({
                    title: 'Checking...',
                    text: 'Harap Tunggu sebentar..',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                try {
                    const response = await fetch(`/api/check-email-outlet`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ email: emailInput })
                    });

                    const result = await response.json();

                    // Close loading alert
                    Swal.close();

                    if (result.exists) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Email sudah ada!',
                            text: `Email ${emailInput} sudah ada dalam database!`,
                            confirmButtonColor: '#3085d6',
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Email belum terdaftar!',
                            text: `Email ${emailInput} belum terdaftar!`,
                            confirmButtonColor: '#3085d6',
                        });
                    }
                } catch (error) {
                    // Close loading alert on error
                    Swal.close();
                    console.error('Error checking email:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan!',
                        text: 'Gagal memeriksa email, silakan coba lagi.',
                        confirmButtonColor: '#3085d6',
                    });
                }
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Email tidak valid!',
                    text: `Email ${emailInput} tidak valid! Silakan masukkan alamat email yang valid.`,
                    confirmButtonColor: '#3085d6',
                });
            }
        }

        @if ($errors->any())
            let errorMessages = '';
            @if ($errors->has('email'))
                errorMessages += '{{ addslashes($errors->first('email')) }}\n'; // Specific email error
            @endif
            @if ($errors->has('error'))
                errorMessages += '{{ addslashes($errors->first('error')) }}\n'; 
            @endif

            const Toast = Swal.mixin({
                toast: true,
                position: "top",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            Toast.fire({
                icon: "error",
                title: "Registration gagal!",
                text: errorMessages // Display all error messages here
            });
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                width: 600,
                timer: 3000,
                position: 'top-end',
                toast: true,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
        @endif

        var mediaStream = null; // Store the media stream globally

        function previewImage(event) {
            var imagePreview = document.getElementById('image-preview');
            imagePreview.innerHTML = ''; // Clear previous content
            var reader = new FileReader();
            reader.onload = function() {
                var imgElement = document.createElement('img');
                imgElement.src = reader.result;
                imgElement.className = 'max-h-full max-w-full rounded-lg object-contain'; // Use object-contain to maintain aspect ratio within the container
                imagePreview.appendChild(imgElement);
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

            // Display the image in the upload area
            var imagePreview = document.getElementById('image-preview');
            imagePreview.innerHTML = '';
            var imgElement = document.createElement('img');
            imgElement.src = dataURL;
            imgElement.className = 'h-full w-full object-cover rounded-lg'; // Set image to cover the container
            imagePreview.appendChild(imgElement);

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

        document.addEventListener('DOMContentLoaded', function () {
            const buatButton = document.querySelector('#status-user button');
            const detailButton = document.querySelector('#status-user-berhasil button');
            const statusUser = document.getElementById('status-user');
            const statusBerhasil = document.getElementById('status-user-berhasil');
            const outletRegister = document.getElementById('outlet-register');
            const detailOutlet = document.getElementById('detail-outlet');
            const kembaliButton = document.getElementById('kembali');

            if (buatButton) {
                buatButton.addEventListener('click', function () {
                    statusUser.classList.add('hidden');
                    outletRegister.classList.remove('hidden');
                });

                document.getElementById('daftar').addEventListener('click', function (event) {
                    const emailInput = document.getElementById('email').value;
                    const pinInput = document.getElementById('pin').value;
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                    // Validasi email
                    if (!emailPattern.test(emailInput)) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Email tidak valid!',
                            text: 'Mohon masukkan email yang valid.',
                            confirmButtonColor: '#3085d6',
                        });
                        return; // Stop form submission
                    }

                    // Validasi PIN (minimum 4 digits)
                    if (pinInput.length < 4) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Pin Kurang!',
                            text: 'Mohon masukkan PIN yang terdiri dari minimal 4 angka.',
                            confirmButtonColor: '#3085d6',
                        });
                        return; // Stop form submission
                    }

                    document.getElementById('outlet-form').submit();
                    
                });
            }
            if (kembaliButton) {
                kembaliButton.addEventListener('click', function () {
                    statusUser.classList.remove('hidden');
                    outletRegister.classList.add('hidden');
                });
            }
            if (detailButton) {
                detailButton.addEventListener('click', function () {
                    console.log('Detail button clicked');
                    statusBerhasil.classList.add('hidden');
                    detailOutlet.classList.remove('hidden');
                });
            }

        });
    </script>


    {{-- SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</body>
</html>