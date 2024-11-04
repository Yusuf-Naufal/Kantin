<html lang="en">

<x-header :title="$title" />

<body class="w-full h-screen bg-gray-200">
    
    <x-nav-bar></x-nav-bar>

    <div class="w-full py-4 flex justify-center bg-gray-200">
        {{ $slot }}
    </div>


    {{-- TAILWIND SCRIPT  --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    {{-- SWEETALERT SCRIP --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Alert Success
        @if (session('success'))
            document.addEventListener('DOMContentLoaded', function() {
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
            });
        @endif

        // Alert Konfirmasi Logout
        document.getElementById('logout-btn').addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah default submit form
            
            Swal.fire({
                title: 'Apa Anda Yakin?',
                text: "Kamu akan keluar dari akun!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit(); // Kirim form logout jika dikonfirmasi
                }
            });
        });

    </script>
</body>
</html>