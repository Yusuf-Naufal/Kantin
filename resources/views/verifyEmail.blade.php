<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Email</title>
    {{-- TAILWIND CSS  --}}
    {{-- @vite('resources/css/app.css') --}}

    <link rel="stylesheet" href="/build/assets/app-DMXIxZ_f.css">
    <link rel="stylesheet" href="/build/assets/app-CW2gkweu.css">

    {{-- FLOWBITE CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" />
</head>
<body class="w-full h-screen flex items-center justify-center p-3" style="background: whitesmoke">

    <div class="container mx-auto shadow-lg rounded-lg bg-white max-w-md p-6">
        <h2 class="text-center text-2xl font-bold mb-4">Verifikasi Email Anda</h2>
        <p class="text-center text-gray-600 mb-6">
            Untuk melanjutkan, silakan verifikasi alamat email Anda. Jika Anda belum menerima email verifikasi, Anda dapat mengirim ulang email tersebut di bawah ini.
        </p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div class="flex justify-center">
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 ease-in-out">
                    Kirim Ulang Email Verifikasi
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
        @if (session('message'))
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
            title: "{{ session('message') }}"
            });
        @endif
    </script>
</body>
</html>