<x-admin-layout :title="$title">
    <div class="w-full p-2">
        <h1 class="text-2xl font-bold mb-4">User : Create</h1>

        <!-- Card Container -->
        <div class="bg-white h-auto w-full shadow-md rounded-lg p-2">
            <form id="users-form" action="{{ route('admin-store-user') }}" method="POST" enctype="multipart/form-data">
                @csrf
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
                                        <div id="image-preview" class="flex items-center justify-center w-full h-full">
                                            <!-- Default SVG Icon -->
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                        </div>
                                        <input id="dropzone-file" type="file" class="hidden" accept="image/*" name="foto" onchange="previewImage(event)" />
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
                                <div class="flex gap-4 flex-col lg:flex-row mb-4">
                                    <div class="w-full">
                                        <label class="block text-sm font-medium text-gray-700" for="name">Nama Lengkap</label>
                                        <input type="text" id="name" name="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" >
                                    </div>
                                    <div class="w-full">
                                        <label for="role" class="block text-sm font-medium text-gray-700">Role Akun</label>
                                        <select name="role" id="role" onchange="handleRoleChange()" style="height: 41px;" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="" disabled selected>Pilih Role</option>
                                            <option value="User">User</option>
                                            <option value="Karyawan">Karyawan</option>
                                            <option value="Master">Master</option>
                                            <option value="Admin">Admin</option>
                                        </select>
                                    </div>
                                    
                                </div>
        
                                <div class="flex gap-4 flex-col lg:flex-row mb-4">
                                    <div class="w-full">
                                        <label class="block text-sm font-medium text-gray-700" for="no_telp">Telepon</label>
                                        <input type="text" id="no_telp" maxlength="20" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="no_telp">
                                    </div>
                                    <div class="w-full">
                                        <label class="block text-sm font-medium text-gray-700" for="username">Username</label>
                                        <input type="text"  id="username" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="username">
                                    </div>
                                </div>

                                <div class="flex gap-4 flex-col lg:flex-row mb-4">
                                    <div class="w-full">
                                        <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                                        <div class="relative">
                                            <input type="text" id="email" name="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 pr-12 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Email@example.com">
                                            <button type="button" onclick="checkEmail()" class="absolute inset-y-0 right-0 flex items-center px-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M10.5 2c.58 0 1.15.058 1.699.17a1 1 0 1 1-.398 1.96a6.5 6.5 0 1 0 5.069 7.671a1 1 0 1 1 1.96.398a8.5 8.5 0 0 1-1.457 3.303l-.197.26l3.652 3.652a1 1 0 0 1-1.32 1.498l-.094-.084l-3.652-3.652A8.5 8.5 0 1 1 10.5 2M19 1a1 1 0 0 1 .898.56l.048.117l.13.378a3 3 0 0 0 1.684 1.8l.185.07l.378.129a1 1 0 0 1 .118 1.844l-.118.048l-.378.13a3 3 0 0 0-1.8 1.684l-.07.185l-.129.378a1 1 0 0 1-1.844.117l-.048-.117l-.13-.378a3 3 0 0 0-1.684-1.8l-.185-.07l-.378-.129a1 1 0 0 1-.118-1.844l.118-.048l.378-.13a3 3 0 0 0 1.8-1.684l.07-.185l.129-.378A1 1 0 0 1 19 1m0 3.196a5 5 0 0 1-.804.804q.448.355.804.804q.355-.448.804-.804A5 5 0 0 1 19 4.196"/></g></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label class="block text-sm font-medium text-gray-700" for="password">Password <span class="font-thin">(Min 8, 1 angka, 1 kapital)</span></label>
                                        <div class="relative mt-1">
                                            <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:outline-none focus:ring-0 focus:border-none rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required />
                                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-2 flex items-center text-gray-500">
                                                <!-- Eye Icon (visible) -->
                                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="visible w-5 h-5">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="M21.257 10.962c.474.62.474 1.457 0 2.076C19.764 14.987 16.182 19 12 19s-7.764-4.013-9.257-5.962a1.69 1.69 0 0 1 0-2.076C4.236 9.013 7.818 5 12 5s7.764 4.013 9.257 5.962"/>
                                                        <circle cx="12" cy="12" r="3"/>
                                                    </g>
                                                </svg>
                                                <!-- Eye-off Icon (hidden) -->
                                                <svg id="eyeOffIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="hidden w-5 h-5">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0-4 0"/>
                                                        <path d="M13.048 17.942A9 9 0 0 1 12 18q-5.4 0-9-6q3.6-6 9-6t9 6a18 18 0 0 1-1.362 1.975M22 22l-5-5m0 5l5-5"/>
                                                    </g>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="flex gap-4 flex-col lg:flex-row mb-4">
                                    <div class="w-full">
                                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" id="jenis_kelamin" style="height: 41px;" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="w-full">
                                        <label class="block text-sm font-medium text-gray-700" for="tanggal_lahir">Tanggal Lahir</label>
                                        <input value="" type="date" id="tanggal_lahir" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="tanggal_lahir">
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
                            <input type="text" id="alamat" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="alamat">
                        </div>
                    </div>
                </div>

                <!-- Info Karyawan Section -->
                <div class="border-b border-gray-300 py-4">
                    <button type="button" class="w-full text-left flex justify-between items-center align-middle" onclick="toggleSection('info-karyawan')">
                        <h1 class="text-xl font-bold">Info Bekerja</h1>
                        <svg class="w-4 h-4 transform transition-transform" id="info-karyawan-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="info-karyawan" class="hidden mt-4">
                        <input type="text" name="status" id="status" class="hidden">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggle" class="sr-only peer">
                            
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Berhenti / Bekerja</span>
                        </label>
                    </div>
                </div>


                <!-- Button Container -->
                <div class="w-full flex justify-end mt-6">
                    <a href="{{ route('admin-user') }}" class="text-gray-700 bg-gray-300 hover:bg-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">
                        Batal
                    </a>
                    <button id="store-button" type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">
                        Simpan
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

    <!-- JavaScript for Image Preview -->
    <script>
        // CEK EMAIL APAKAH SUDAH ADA DALAM DATABASE
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
                    const response = await fetch(`/api/check-email-user`, {
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

        // CEK PASSWORD
        document.getElementById('password').addEventListener('input', function () {
            const password = this.value;
            const storeButton = document.getElementById('store-button');
            const regex = /^(?=.*\d)(?=.*[A-Z]).{8,}$/;

            if (regex.test(password)) {
                storeButton.disabled = false;
                this.classList.remove('border-red-500'); 
                this.classList.add('border-green-500'); 
            } else {
                storeButton.disabled = true;
                this.classList.remove('border-green-500'); 
                this.classList.add('border-red-500'); 
            }
        });

        // LIHAT PASSWORD
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeOffIcon = document.getElementById('eyeOffIcon');

        togglePasswordButton.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle icons based on the password visibility
            if (type === 'password') {
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            } else {
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            }
        });

        // MENGAMBIL GAMBAR MELALUI KAMERA
        var mediaStream = null; // Store the media stream globally

        function previewImage(event) {
            var imagePreview = document.getElementById('image-preview');
            imagePreview.innerHTML = ''; // Clear previous content
            var reader = new FileReader();
            reader.onload = function() {
                var imgElement = document.createElement('img');
                imgElement.src = reader.result;
                imgElement.className = 'max-h-full max-w-full rounded-lg object-contain';
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

        // MENYEMBUNTIKAN HALAMAN
        function toggleSection(id) {
            const section = document.getElementById(id);
            const icon = document.getElementById(id + '-icon');
            section.classList.toggle('hidden');
            icon.classList.toggle('transform');
            icon.classList.toggle('rotate-180');
        }

        // KETIKA LOAD HALAMAN
        window.onload = function() {
            // Ensure the section is visible
            const section = document.getElementById('data-pribadi');
            section.classList.remove('hidden');
        };

        // HANDLE ROLE USER
        function handleRoleChange() {
            const selectedRole = document.getElementById('role').value;
            const checkbox = document.getElementById('toggle');
            const statusInput = document.getElementById('status');

            // Jika role adalah User atau Admin, disable checkbox dan set status ke Aktif
            if (selectedRole === 'User' || selectedRole === 'Admin') {
                checkbox.disabled = true;
                checkbox.checked = false;
                statusInput.value = 'Aktif';
            } else {
                // Jika role adalah Karyawan atau Master, enable checkbox dan set default status ke Nonaktif
                checkbox.disabled = false; 
                checkbox.checked = false; // default unchecked
                statusInput.value = 'Nonaktif'; // Default Nonaktif

                // Mengubah status ketika checkbox diaktifkan atau dinonaktifkan
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        statusInput.value = 'Bekerja';
                    } else {
                        statusInput.value = 'Nonaktif';
                    }
                });
            }
        }

    </script>
</x-admin-layout>
