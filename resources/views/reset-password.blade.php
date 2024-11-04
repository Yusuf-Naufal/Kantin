<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>

    {{-- TAILWIND CSS  --}}
    @vite('resources/css/app.css')
    {{-- FLOWBITE CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" />
</head>
<body class="w-full h-screen flex items-center justify-center p-3" style="background: whitesmoke">

    <div class="container mx-auto shadow-lg rounded-lg bg-white max-w-md p-6">
        <h2 class="text-center text-2xl font-bold mb-4">Atur Ulang Password</h2>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ old('email', $email) }}">

            <div class="mb-5">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password Baru</label>
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

            <div class="mb-5">
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>

            <div class="flex justify-center">
                <button type="submit" id="reset-button" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 ease-in-out">
                    Atur Ulang Password
                </button>
            </div>
        </form>
    </div>

    {{-- TAILWIND SCRIPT  --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    {{-- SWEETALERT SCRIP --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // ALERT ERROR
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
                title: "Reset gagal!",
                text: errorMessages // Display all error messages here
            });
        @endif

        // CEK PASSWORD
        document.getElementById('password').addEventListener('input', function () {
            const password = this.value;
            const regex = /^(?=.*\d)(?=.*[A-Z]).{8,}$/;
            const message = document.getElementById('password-message');
            const resetButton = document.getElementById('reset-button');

            if (regex.test(password)) {
                message.textContent = "Password is valid";
                message.classList.remove("text-red-500");
                message.classList.add("text-green-500");
                resetButton.disabled = false;
            } else {
                message.textContent = "Password minimal 8 karakter, terdiri dari 1 huruf besar dan 1 angka.";
                message.classList.remove("text-green-500");
                message.classList.add("text-red-500");
                resetButton.disabled = true;
            }
        });

        // LIAT PASSWORD
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

    </script>

</body>
</html>