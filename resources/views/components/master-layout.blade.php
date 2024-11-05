<html lang="en">
<x-header :title="$title"></x-header>
<body>
    <x-master-aside></x-master-aside>

    <div class="p-2 sm:ml-64">
        <div class="p-2 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
            {{ $slot }}
        </div>
    </div>


    {{-- SCRIPT --}}
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <script src="/build/assets/app-CFG0kKgu.js "></script>

    {{-- SWEETALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- CHART --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


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
            });
        @endif
        
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
                        confirmButtonText: 'Ya, Logout!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('logout-form').submit(); // Redirect to logout route
                        }
                    });
                });
            }
        });
    </script>

</body>
</html>