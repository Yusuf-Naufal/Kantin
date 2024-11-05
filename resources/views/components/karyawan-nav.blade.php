<!-- Navbar -->
<nav class="bg-white border-b border-gray-200 p-4 flex justify-between items-center shadow-md h-16 rounded-md">
    <div class="flex items-center space-x-4">
        <button id="toggle-sidebar" class="p-2 text-gray-500 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
            </svg>
        </button>
        <h1 class="text-2xl font-semibold text-center mt-1 text-gray-700">POS</h1>
    </div>
    <div class="flex items-center">
        <div class="relative">
           <div class="relative">
                <button class="relative z-10 block p-2 text-gray-600 rounded-full focus:outline-none" id="notification-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <g>
                                <path stroke-dasharray="4" stroke-dashoffset="4" d="M12 3v2">
                                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.2s" values="4;0"/>
                                </path>
                                <path stroke-dasharray="28" stroke-dashoffset="28" d="M12 5c-3.31 0 -6 2.69 -6 6l0 6c-1 0 -2 1 -2 2h8M12 5c3.31 0 6 2.69 6 6l0 6c1 0 2 1 2 2h-8">
                                    <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.2s" dur="0.4s" values="28;0"/>
                                </path>
                                <animateTransform fill="freeze" attributeName="transform" begin="0.9s" dur="6s" keyTimes="0;0.05;0.15;0.2;1" type="rotate" values="0 12 3;3 12 3;-3 12 3;0 12 3;0 12 3"/>
                            </g>
                            <path stroke-dasharray="8" stroke-dashoffset="8" d="M10 20c0 1.1 0.9 2 2 2c1.1 0 2 -0.9 2 -2">
                                <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.6s" dur="0.2s" values="8;0"/>
                                <animateTransform fill="freeze" attributeName="transform" begin="1.1s" dur="6s" keyTimes="0;0.05;0.15;0.2;1" type="rotate" values="0 12 8;6 12 8;-6 12 8;0 12 8;0 12 8"/>
                            </path>
                        </g>
                    </svg>
                    <span id="notification-badge" class="absolute top-2 right-2 w-3 h-3 bg-red-600 rounded-full hidden"></span>
                </button>
                <div class="absolute right-0 top-10 w-48 bg-white rounded-lg shadow-lg p-2 hidden" id="notifications">
                    <!-- Add notification items here -->
                </div>
            </div>

        </div>
        <div class="relative">
            <button class="relative z-10 block p-2 text-gray-600 rounded-full focus:outline-none" aria-expanded="false" data-dropdown-toggle="user-menu">
                <img src="{{ auth()->user()->foto ? Storage::url('assets/' . auth()->user()->foto) : asset('public/assets/icon-profile.png') }}" alt="User" class="rounded-full h-10 w-10">
            </button>
            <div class="z-50 hidden min-w-max text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="user-menu">
                <div class="px-4 pt-3" role="none">
                    <p class="text-sm text-gray-900 dark:text-white" role="none">
                    <b>{{ auth()->user()->name }}</b>
                    </p>
                    <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                    {{ auth()->user()->email }}
                    </p>
                </div>
                <ul class="py-1" role="none">
                    @if(Auth::user()->role == 'Master')
                        <a href="{{ route('pemilik-dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                            Dashboard
                        </a>
                    @endif
                    <li>
                    <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Beranda</a>
                    </li>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form" class="inline">
                        @csrf
                        <a type="button" id="logout-button" class="block px-4 py-2 text-sm text-red-700 hover:bg-red-100 dark:text-red-300 dark:hover:bg-red-600 dark:hover:text-white">
                            Logout
                        </a>
                    </form>
                </ul>
            </div>
        </div>
    </div>
</nav>

