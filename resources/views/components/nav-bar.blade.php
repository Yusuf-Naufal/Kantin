<nav class="dark:bg-gray-900 fixed w-full z-20 top-0 dark:border-gray-600 shadow-md" style="background: white">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto py-2 px-3">
        <a href="{{ route('home') }}" class="flex items-center space-x-2 rtl:space-x-reverse">
            <img src="{{ asset('public/assets/logoMyKantin.png') }}" class="h-8" alt="Logo">
            <span class="self-center text-2xl font-bold whitespace-nowrap dark:text-white">MyKantin</span>
        </a>
        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            @guest
                <a href="{{ route('login') }}" type="button" class="focus:outline-none text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2 me-2 transition-all duration-300 ease-in-out transform hover:scale-105">Login</a>
            @endguest
                
            @auth
                <button type="button" class="flex text-sm bg-gray-800 dark:bg-gray-600 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    @if (auth()->user()->foto && Storage::exists('assets/' . auth()->user()->foto))
                            <img class="w-10 h-10 rounded-full object-cover border-2 border-gray-300 dark:border-gray-500 shadow-md" src="{{ Storage::url('app/public/assets/' . auth()->user()->foto) }}" alt="User">
                        @else
                            @if (auth()->user()->jenis_kelamin === 'Laki-laki')
                                <img class="w-10 h-10 rounded-full object-cover border-2 border-gray-300 dark:border-gray-500 shadow-md" src="{{ asset('public/assets/icon-male.png') }}" alt="User">
                            @elseif (auth()->user()->jenis_kelamin === 'Perempuan')
                                <img class="w-10 h-10 rounded-full object-cover border-2 border-gray-300 dark:border-gray-500 shadow-md" src="{{ asset('public/assets/icon-female.png') }}" alt="User">
                            @else
                                <img class="w-10 h-10 rounded-full object-cover border-2 border-gray-300 dark:border-gray-500 shadow-md" src="{{ asset('public/assets/icon-profile.png') }}" alt="User">
                            @endif
                        @endif
                </button>
                <!-- Dropdown menu -->
                <div class="z-50 hidden my-4 items-start text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
                    <div class="px-4 py-3">
                    <span class="block text-sm text-gray-900 dark:text-white">{{ Str::limit(auth()->user()->name, 14, '...') }}</span>
                    <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">{{ auth()->user()->email }}</span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            @if (auth()->user()->role == 'Admin')
                                <a href="{{ route('admin-dashboard') }}" class="w-full block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>  
                            @else
                                @if ( auth()->user()->id_outlet == null)
                                    <a href="{{ route('pemilik-regiter-outlet') }}" 
                                    class="w-full block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white" 
                                    onclick="checkUserData(event)">My Kantin</a>
                                @else  
                                    <a href="{{ route('pemilik-dashboard') }}" class="w-full block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">My Kantin</a>  
                                @endif
                            @endif
                        </li>
                        <li>
                            <a href="{{ route('edit-user-profile', auth()->user()->uid) }}" class="w-full block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Edit Profile</a>
                        </li>
                        <li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <a id="logout-btn" class="cursor-pointer w-full left-0 justify-start m-0 block px-4 py-2 text-sm text-red-800 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-red-200 dark:hover:text-white">
                                    Sign out
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
                {{-- <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                    </svg>
                </button> --}}
            @endauth
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
            <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    {{-- <a href="/" class="block px-3 py-2 text-gray-900 rounded hover:bg-gray-700 hover:text-white md:px-3 md:py-2 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white transition duration-300">
                        Home
                    </a> --}}
                </li>
            </ul>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function checkUserData(event) {
            // Mencari data pengguna dari elemen HTML atau API
            const userData = {
                username: '{{ auth()->user()->username ?? '' }}',
                alamat: '{{ auth()->user()->alamat ?? '' }}',
                no_telp: '{{ auth()->user()->no_telp ?? '' }}'
            };

            // Cek apakah data pengguna sudah lengkap
            if (!userData.username || !userData.alamat || !userData.no_telp) {
                event.preventDefault();
                // Menampilkan SweetAlert
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Tidak Lengkap',
                    text: 'Silakan lengkapi data Anda sebelum melanjutkan.',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
            }
        }
    </script>
</nav>