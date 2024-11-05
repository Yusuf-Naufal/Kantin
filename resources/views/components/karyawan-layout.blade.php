<!DOCTYPE html>
<html lang="en">
    <x-header :title="$title"></x-header>
<body class="bg-gray-100">

    <div class="w-full h-screen p-3">
        {{ $slot }}
    </div>

    {{-- SCRIPT --}}
    {{-- <script src="../path/to/flowbite/dist/flowbite.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <script src="/build/assets/app-CFG0kKgu.js"></script>

    {{-- SWEETALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Sidebar toggle script
        const sidebarToggle = document.getElementById('toggle-sidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const closeToggle = document.getElementById('close-sidebar');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            mainContent.classList.toggle('md:pl-[17rem]');
            mainContent.classList.toggle('w-full');
        });

        closeToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            mainContent.classList.toggle('md:pl-[17rem]');
            mainContent.classList.toggle('w-full');
        });

        // Ensure initial state on page load
        window.addEventListener('DOMContentLoaded', () => {
            if (sidebar.classList.contains('-translate-x-full')) {
                mainContent.classList.add('w-full');
            }
        });

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
    
        function checkOrders() {
            fetch('/api/check-orders')  // Adjust this URL to your actual API endpoint
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const badge = document.getElementById('notification-badge');
                    if (data.hasOrders) { // Assuming your API returns { hasOrders: true/false }
                        badge.classList.remove('hidden'); // Show the badge if there are orders
                        speak();
                    } else {
                        badge.classList.add('hidden'); // Hide the badge if no orders
                    }
                })
                .catch(error => {
                    console.error('Error fetching order status:', error);
                });
        }

        function updateOrderProcessCount() {
            fetch('/api/orders/process')  // Adjust the URL to your API endpoint
                .then(response => response.json())
                .then(data => {
                    const orderCountBadge = document.getElementById('process-count');
                    const count = data.orderCount; // Assumes API response includes { orderCount: number }

                    if (count > 0) {
                        orderCountBadge.textContent = count;
                        orderCountBadge.classList.remove('hidden'); // Show badge
                    } else {
                        orderCountBadge.classList.add('hidden'); // Hide badge if no orders
                    }
                })
                .catch(error => console.error('Error fetching order count:', error));
        }

        function updateOrderCount() {
            fetch('/api/orders/count')  // Adjust the URL to your API endpoint
                .then(response => response.json())
                .then(data => {
                    const orderCountBadge = document.getElementById('order-count');
                    const count = data.orderCount; // Assumes API response includes { orderCount: number }

                    if (count > 0) {
                        orderCountBadge.textContent = count;
                        orderCountBadge.classList.remove('hidden'); // Show badge
                    } else {
                        orderCountBadge.classList.add('hidden'); // Hide badge if no orders
                    }
                })
                .catch(error => console.error('Error fetching order count:', error));
        }

        function updateOrderFinishCount() {
            fetch('/api/orders/finish')  // Adjust the URL to your API endpoint
                .then(response => response.json())
                .then(data => {
                    const orderCountBadge = document.getElementById('finish-count');
                    const count = data.orderCount; // Assumes API response includes { orderCount: number }

                    if (count > 0) {
                        orderCountBadge.textContent = count;
                        orderCountBadge.classList.remove('hidden'); // Show badge
                    } else {
                        orderCountBadge.classList.add('hidden'); // Hide badge if no orders
                    }
                })
                .catch(error => console.error('Error fetching order count:', error));
        }
        
        updateOrderCount();
        updateOrderProcessCount();
        updateOrderFinishCount();
        checkOrders();

        // Update tiap 1 menit
        setInterval(checkOrders, 60000);
        setInterval(updateOrderCount, 60000);
        setInterval(updateOrderProcessCount, 60000);
        setInterval(updateOrderFinishCount, 60000);

        function speak() {
            // Create a SpeechSynthesisUtterance
            const utterance = new SpeechSynthesisUtterance("Ada Orderan!");

            // Select a voice
            const voices = speechSynthesis.getVoices();
            utterance.voice = voices[3]; // Choose a specific voice

            // Speak the text
            speechSynthesis.speak(utterance);
        }

    </script>

</body>
</html>
