<x-master-layout :title="$title">
    <div class="w-full p-2">
        <h1 class="text-2xl font-bold mb-4">Karyawan : Edit</h1>

        <!-- Card Container -->
        <div class="bg-white h-auto w-full shadow-md rounded-lg p-2">
            <form id="users-form" action="{{ route('pemilik-update-karyawan', $user->uid) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Input hidden untuk status -->
                <input type="hidden" id="status" name="status" value="{{ $user->status }}" />

                <!-- Data Pribadi Section -->
                <div class="border-b border-gray-300 py-4">
                    <button type="button" class="w-full text-left flex justify-between items-center align-middle" onclick="toggleSection('data-pribadi')">
                        <h1 class="text-xl font-bold">Data Pribadi</h1>
                        <svg class="w-4 h-4 transform transition-transform" id="data-pribadi-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <div id="data-pribadi" class="hidden mt-4">
                        <!-- Form Fields -->
                        <div class="flex justify-center gap-4 flex-col lg:flex-row items-center">
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
                                        <img class="w-full h-full rounded-md" id="image-update" src="{{ Storage::url('assets/' . $user->foto) }}" alt="">
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
                                <div class="mb-4 flex gap-4 flex-col lg:flex-row">
                                    <div class="w-full">
                                        <label class="block text-sm font-medium text-gray-700" for="name">Nama Lengkap</label>
                                        <input type="text" value="{{ $user->name }}" id="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="name">
                                    </div>
                                </div>
        
                                <div class="mb-4 flex gap-4 flex-col lg:flex-row">
                                    <div class="w-full">
                                        <label class="block text-sm font-medium text-gray-700" for="no_telp">Telepon</label>
                                        <input type="text" value="{{ $user->no_telp }}" id="no_telp" maxlength="20" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="no_telp">
                                    </div>
                                    <div class="w-full">
                                        <label class="block text-sm font-medium text-gray-700" for="username">Username</label>
                                        <input type="text" value="{{ $user->username }}" id="username" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="username">
                                    </div>
                                </div>

                                <div class="flex gap-4 mb-4">
                                    <div class="w-full ">
                                        <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                                        <div class="relative">
                                            <input type="text" value="{{ $user->email }}" id="email" name="" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 pr-12 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Email@example.com" readonly>
                                            <button type="button" onclick="checkEmail()" class="absolute inset-y-0 right-0 flex items-center px-4 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32"><path fill="currentColor" d="M24.879 2.879A3 3 0 1 1 29.12 7.12l-8.79 8.79a.125.125 0 0 0 0 .177l8.79 8.79a3 3 0 1 1-4.242 4.243l-8.79-8.79a.125.125 0 0 0-.177 0l-8.79 8.79a3 3 0 1 1-4.243-4.242l8.79-8.79a.125.125 0 0 0 0-.177l-8.79-8.79A3 3 0 0 1 7.12 2.878l8.79 8.79a.125.125 0 0 0 .177 0z"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="flex gap-4 flex-col lg:flex-row mb-4">
                                    <div class="w-full">
                                        <label class="block text-sm font-medium text-gray-700" for="jenis_kelamin">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" id="" style="height: 41px;" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="Laki-laki" {{ $user->jenis_kelamin === 'Laki-laki' ? 'selected' : '' }}>Laki - laki</option>
                                            <option value="Perempuan" {{ $user->jenis_kelamin === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="w-full">
                                        <label class="block text-sm font-medium text-gray-700" for="tanggal_lahir">Tanggal Lahir</label>
                                        <input value="{{ $user->tanggal_lahir }}" type="date" id="tanggal_lahir" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="tanggal_lahir">
                                    </div>
                                </div>
                                
                            </div>
                             
                        </div>
                    </div>
                </div>

                <!-- Alamat Section -->
                <div class="border-b border-gray-300 py-4">
                    <button type="button" class="w-full text-left flex justify-between items-center align-middle" onclick="toggleSection('alamat')">
                        <h1 class="text-xl font-bold">Alamat</h1>
                        <svg class="w-4 h-4 transform transition-transform" id="alamat-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="alamat" class="hidden mt-4">
                        <!-- Alamat fields here -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700" for="alamat">Alamat Lengkap</label>
                            <input type="text" value="{{ $user->alamat }}" id="alamat" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="alamat">
                        </div>
                    </div>
                </div>

                <!-- Info Karyawan Section -->
                <div class="border-b border-gray-300 py-4">
                    <button type="button" class="w-full text-left flex justify-between items-center align-middle" onclick="toggleSection('info-karyawan')">
                        <h1 class="text-xl font-bold">Info Karyawan</h1>
                        <svg class="w-4 h-4 transform transition-transform" id="info-karyawan-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="info-karyawan" class="hidden mt-4">
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
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggle" class="sr-only peer" {{ $user->status == 'Bekerja' ? 'checked' : ''}} 
                            onclick="updateStatus()">

                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Berhenti / Bekerja</span>
                        </label>

                        @endif
                    </div>
                </div>


                <!-- Button Container -->
                <div class="w-full flex justify-end mt-6">
                    <a href="{{ route('pemilik-karyawan') }}" class="text-gray-700 bg-gray-300 hover:bg-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">
                        Batal
                    </a>
                    <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">
                        Ubah
                    </button>
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
    </div>

    {{-- SWEETALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JavaScript for Image Preview -->
    <script>
        @if ($errors->any())
            let errorMessages = '';
            @if ($errors->has('email'))
                errorMessages += '{{ addslashes($errors->first('email')) }}\n'; // Specific email error
            @endif
            @if ($errors->has('error'))
                errorMessages += '{{ addslashes($errors->first('error')) }}\n'; // General registration error
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

        const currentEmail = "{{ $user->email }}";
        async function checkEmail() {
            const emailInput = document.getElementById('email').value;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email pattern

            if (emailPattern.test(emailInput)) {
                // Show loading alert
                Swal.fire({
                    title: 'Checking...',
                    text: 'Harap Tunggu sebentar..',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false,
                });

                try {
                    // Check if the email is the same as the user's current email
                    if (emailInput === currentEmail) {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            title: 'Ini email Anda!',
                            text: 'Tidak bisa merubah email!',
                            confirmButtonColor: '#3085d6',
                        });
                        return; // Exit the function early
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

        function updateStatus() {
            const toggle = document.getElementById('toggle');
            const statusInput = document.getElementById('status');

            // Update nilai status berdasarkan kondisi checkbox
            if (toggle.checked) {
                statusInput.value = "Bekerja";
            } else {
                statusInput.value = "Nonaktif";
            }
        }

        // KETIKA LOAD HALAMAN
        window.onload = function() {
            // Ensure the section is visible
            const section = document.getElementById('data-pribadi');
            section.classList.remove('hidden');
        };

    </script>
</x-admin-layout>
