<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>

    {{-- TAILWIND CSS  --}}
    @vite('resources/css/app.css')
    {{-- FLOWBITE CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" />
</head>
<body class="w-full flex items-center justify-center h-screen p-3" style="background: whitesmoke">
    
    <div class="container shadow-lg rounded-lg bg-white max-w-md p-6">
        <form id="registerForm" action="{{ route('register') }}" method="POST">
            @csrf
            <h1 class="font-bold text-3xl text-center mb-4">Register</h1>
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                <input type="name" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
            </div>
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email <span class="font-thin">(Cek email)</span></label>
                <div class="relative">
                    <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-32 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@example.com" required />
                    <button type="button" id="checkEmailBtn" class="absolute inset-y-0 right-0 bg-blue-500 text-white px-4 py-2 rounded-lg focus:ring-4 focus:ring-blue-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"><path fill="currentColor" d="M9.5 3A6.5 6.5 0 0 1 16 9.5c0 1.61-.59 3.09-1.56 4.23l.27.27h.79l5 5l-1.5 1.5l-5-5v-.79l-.27-.27A6.52 6.52 0 0 1 9.5 16A6.5 6.5 0 0 1 3 9.5A6.5 6.5 0 0 1 9.5 3m0 2C7 5 5 7 5 9.5S7 14 9.5 14S14 12 14 9.5S12 5 9.5 5"/></svg>
                    </button>
                </div>
                <p id="emailMessage" class="text-sm mt-2"></p>
            </div>
            <div class="mb-5">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
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
                <p id="password-message" class="text-red-500 text-sm mt-2"></p>
            </div>
            <div class="w-full">
                <button id="register-button" style="width: 100%" type="submit" class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Register</button>
            </div>
        </form>
    </div>





    {{-- BAGIAN SCRIPT --}}
    <script>
        // CEK PASSWORD
        document.getElementById('password').addEventListener('input', function () {
            const password = this.value;
            const message = document.getElementById('password-message');
            const registerButton = document.getElementById('register-button');
            const regex = /^(?=.*\d)(?=.*[A-Z]).{8,}$/;

            if (regex.test(password)) {
                message.textContent = "Password is valid";
                message.classList.remove("text-red-500");
                message.classList.add("text-green-500");
                registerButton.disabled = false;
            } else {
                message.textContent = "Password minimal 8 karakter, terdiri dari 1 huruf besar dan 1 angka";
                message.classList.remove("text-green-500");
                message.classList.add("text-red-500");
                registerButton.disabled = true;
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

        // CEK EMAIL
        const emailInput = document.getElementById('email');
        const checkEmailBtn = document.getElementById('checkEmailBtn');
        const emailMessage = document.getElementById('emailMessage');

        checkEmailBtn.addEventListener('click', () => {
            const email = emailInput.value;

            if (email.trim() === '') {
                emailMessage.textContent = 'Masukkan email anda!';
                emailMessage.className = 'text-red-500';
                return;
            }

            fetch(`/api/check-email-user?email=${email}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        emailMessage.textContent = 'Email sudah terpakai!';
                        emailMessage.className = 'text-red-500';
                    } else {
                        emailMessage.textContent = 'Email dapat digunakan!';
                        emailMessage.className = 'text-green-500';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    emailMessage.textContent = 'Error checking email.';
                    emailMessage.className = 'text-red-500';
                });
        });
    </script>



    {{-- TAILWIND SCRIPT  --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    {{-- SWEETALERT SCRIP --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if ($errors->any())
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += '{{ $error }}\n';
            @endforeach

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
                title: "Register gagal!",
                text: errorMessages 
            });
        @endif
    </script>
</body>
</html>