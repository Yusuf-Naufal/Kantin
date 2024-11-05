<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Profile : {{ $user->username ?? '??'}}</title>

    <link rel="stylesheet" href="/build/assets/app-DMXIxZ_f.css">
    <link rel="stylesheet" href="/build/assets/app-CW2gkweu.css">

    {{-- TAILWIND CSS  --}}
    {{-- {{-- @vite('resources/css/app.css') --}}

    <link rel="stylesheet" href="/build/assets/app-DMXIxZ_f.css">
    <link rel="stylesheet" href="/build/assets/app-CW2gkweu.css">

    
    {{-- FLOWBITE CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" />
</head>
<body class="flex items-center justify-center p-3 bg-gray-100"> 
    
    <div class="container mx-auto shadow-lg rounded-lg bg-white p-6" style="max-width: 800px;">

        <!-- Header with Title and Toggle Button -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="font-bold text-xl text-gray-800">Edit Profile</h1>
            @if ($user->role === 'User'  || $user->role === 'Admin')
                <!-- Conditionally display Bekerja Checkbox -->
                <label class="inline-flex items-center me-5 cursor-pointer">
                    <input type="checkbox" id="toggle" class="sr-only peer"
                        {{ $user->status == 'Aktif' ? 'checked' : '' }}  
                        onclick="document.getElementById('status').value = this.checked ? 'Aktif' : 'Nonaktif'">
                    <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                    <label for="toggle" class="ms-2 text-xl font-semibold text-gray-900 dark:text-gray-300">Nonaktif / Aktif</label>
                </label>
            @else
            <!-- Conditionally display Bekerja Checkbox -->
            <label class="inline-flex items-center me-5 cursor-pointer">
                <input type="checkbox" id="toggle" class="sr-only peer"
                    {{ $user->status == 'Bekerja' ? 'checked' : ''}}  
                    onclick="document.getElementById('status').value = this.checked ? 'Bekerja' : 'Berhenti'">
                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                <label for="toggle" class="ms-2 text-xl font-semibold text-gray-900 dark:text-gray-300">Berhenti / Bekerja</label>
            </label>
            @endif
        </div>

        <form action="{{ route('update-profile', $user->uid) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" name="status" id="status" value="{{ $user->status ?? 'Nonaktif'}}" class="hidden">
            <!-- Form Section -->
            <div class="flex flex-col lg:flex-row gap-6 items-center justify-center">
                
                <!-- Profile Image Upload Section -->
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
                            <img class="w-full h-full rounded-md" id="image-update" src="{{ Storage::url('app/public/assets/' . $user->foto) }}" alt="">
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
    
                <!-- Form Fields -->
                <div class="w-full flex flex-col gap-4">
    
                    <!-- Name Input -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="name">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ $user->name }}" id="name" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                    </div>
    
                    <!-- Username Input -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="username">Username</label>
                        <input type="text" name="username" value="{{ $user->username }}" id="username" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                    </div>
    
                    <!-- Phone Input -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="no_telp">Telepon</label>
                        <input type="text" name="no_telp" value="{{ $user->no_telp }}" id="no_telp" maxlength="20" pattern="[0-9]*" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-blue-500 focus:border-blue-500" oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                    </div>
    
                    <!-- Gender and Birth Date -->
                    <div class="flex gap-4">
                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700" for="jenis_kelamin">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                                <option value="Laki-laki" {{ $user->jenis_kelamin === 'Laki-laki' ? 'selected' : '' }}>Laki - laki</option>
                                <option value="Perempuan" {{ $user->jenis_kelamin === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700" for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ $user->tanggal_lahir }}" id="tanggal_lahir" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Address Section -->
            <div class="border-t border-gray-300 py-4 mt-6">
                <button type="button" class="w-full text-left flex justify-between items-center" onclick="toggleSection('alamat')">
                    <h1 class="text-xl font-bold">Alamat</h1>
                    <svg class="w-5 h-5 transform transition-transform" id="alamat-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="alamat" class="hidden mt-4">
                    <label class="block text-sm font-medium text-gray-700" for="alamat">Alamat Lengkap</label>
                    <input type="text" name="alamat" value="{{ $user->alamat }}" id="alamat" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
    
            <!-- Save Button -->
            <div class="w-full flex justify-end mt-6">
                <button type="submit" class="bg-green-500 text-white px-5 py-2 rounded-lg hover:bg-green-600">Save</button>
            </div>
        </form>

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
    
    {{-- FLOWBITE SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="/build/assets/app-CFG0kKgu.js "></script>

    {{-- SWEETALERT SCRIP --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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
            }).then(() => {
                // Kembali ke 3 halaman sebelumnya setelah SweetAlert selesai
                window.history.go(-3);
            });
        @endif

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

        function toggleSection(id) {
            const section = document.getElementById(id);
            const icon = document.getElementById(id + '-icon');
            section.classList.toggle('hidden');
            icon.classList.toggle('transform');
            icon.classList.toggle('rotate-180');
        }

        
    </script>
</body>
</html>