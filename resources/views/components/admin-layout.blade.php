<html lang="en">

<x-header :title="$title">


</x-header>

<body class="h-screen">
    <x-admin-aside></x-admin-aside>

    <div class="p-2 sm:ml-64">
        <div class="p-2 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
            {{ $slot }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const logoutButton = document.getElementById('logout-button');

            if (logoutButton) {
                logoutButton.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent the default link behavior

                    // Show SweetAlert confirmation
                    Swal.fire({
                        title: 'Konfirmasi Logout',
                        text: "Apakah Anda yakin ingin keluar?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Ya, Logout!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit the logout form
                            document.getElementById('logout-form').submit();
                        }
                    });
                });
            }
        });

    </script>

{{-- SCRIPT --}}
<script src="../path/to/flowbite/dist/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

<script src="/build/assets/app-CFG0kKgu.js "></script>

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            icon: "error",
            title: "Proses gagal!",
            text: errorMessages
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
</script>



</body>
</html>