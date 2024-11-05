<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lupa Password</title>

    {{-- TAILWIND CSS  --}}
    {{-- @vite('resources/css/app.css') --}}

    <link rel="stylesheet" href="/build/assets/app-DMXIxZ_f.css">
    <link rel="stylesheet" href="/build/assets/app-CW2gkweu.css">

    {{-- FLOWBITE CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" />
</head>
<body class="w-full h-screen flex items-center justify-center p-3" style="background: whitesmoke">
    <div class="container mx-auto shadow-lg rounded-lg bg-white max-w-md p-6">

        <h2 class="text-center text-2xl font-bold mb-4">Reset Password</h2>
        <p class="text-justify text-gray-600 mb-6">
            Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password Anda.
        </p>

        <form method="POST" action="">
            @csrf
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <input type="email" id="email" name="email" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@example.com" />
            </div>

            <div class="flex justify-center">
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 ease-in-out">
                    Kirim Tautan Reset Password
                </button>
            </div>
        </form>
    </div>

    {{-- TAILWIND SCRIPT  --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="/build/assets/app-CFG0kKgu.js "></script>
    {{-- SWEETALERT SCRIP --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('status'))
            const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
            });
            Toast.fire({
            icon: "success",
            title: "{{ session('status') }}"
            });
        @endif
    </script>

</body>
</html>