<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
   <span class="sr-only">Open sidebar</span>
   <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
   <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
   </svg>
</button>

<aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 shadow-lg" aria-label="Sidebar">
   <div class="h-full flex flex-col justify-between px-3 py-4 overflow-y-auto bg-gray-50 item">

      {{-- PROFILE --}}
      <div>
        <div class="px-4 py-4 flex items-center justify-between">
          <div class="flex gap-3 items-center">
            <img id="profileImage" src="{{ auth()->user()->foto ? Storage::url('assets/' . auth()->user()->foto) : asset('public/assets/icon-profile.png') }}" alt="Profile" class="h-12 w-12 rounded-full object-cover ring-1">
              <div>
                  <p class="text-base font-semibold">{{ Str::limit(auth()->user()->name, 14, '...') }}</p>
                  <p class="text-sm text-gray-400">{{ auth()->user()->role }}</p>
                  <p class="UID hidden">{{ auth()->user()->uid }}</p>
              </div>
          </div>
        </div>

        {{-- MENU --}}
        <ul class="space-y-2 font-medium mt-4 border-t border-gray-200 dark:border-gray-700 pt-4">
          <li>
            <a href="{{ route('admin-dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
              <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
              </svg>
              <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Dashboard</span>
            </a>
          </li>
        </ul>

        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
            <li>
               <a href="{{ route('admin-all-outlet') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M5 6h14c.55 0 1-.45 1-1s-.45-1-1-1H5c-.55 0-1 .45-1 1s.45 1 1 1m15.16 1.8c-.09-.46-.5-.8-.98-.8H4.82c-.48 0-.89.34-.98.8l-1 5c-.12.62.35 1.2.98 1.2H4v5c0 .55.45 1 1 1h8c.55 0 1-.45 1-1v-5h4v5c0 .55.45 1 1 1s1-.45 1-1v-5h.18c.63 0 1.1-.58.98-1.2zM12 18H6v-4h6z"/></svg>
               <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Outlet</span>
               </a>
            </li>
            <li>
               <a href="{{ route('admin-transaksi') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14"><path fill="currentColor" fill-rule="evenodd" d="M1.5 0A1.5 1.5 0 0 0 0 1.5v6A1.5 1.5 0 0 0 1.5 9h11A1.5 1.5 0 0 0 14 7.5v-6A1.5 1.5 0 0 0 12.5 0zm6.125 1.454a.625.625 0 1 0-1.25 0v.4a1.532 1.532 0 0 0-.15 3.018l1.197.261a.39.39 0 0 1-.084.773h-.676a.39.39 0 0 1-.369-.26a.625.625 0 0 0-1.178.416c.194.55.673.965 1.26 1.069v.415a.625.625 0 1 0 1.25 0V7.13a1.641 1.641 0 0 0 .064-3.219L6.492 3.65a.281.281 0 0 1 .06-.556h.786a.39.39 0 0 1 .369.26a.625.625 0 1 0 1.178-.416a1.64 1.64 0 0 0-1.26-1.069zM2.75 3.75a.75.75 0 1 1 0 1.5a.75.75 0 0 1 0-1.5m8.5 0a.75.75 0 1 1 0 1.5a.75.75 0 0 1 0-1.5M4.5 9.875c.345 0 .625.28.625.625v2a.625.625 0 1 1-1.25 0v-2c0-.345.28-.625.625-.625m5.625.625a.625.625 0 1 0-1.25 0v2a.625.625 0 1 0 1.25 0zm-2.5.75a.625.625 0 1 0-1.25 0v2a.625.625 0 1 0 1.25 0z" clip-rule="evenodd"/></svg>
                  <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Transaksi</span>
               </a>
            </li>
            <li class="relative">
               <div class="flex items-center justify-between w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                  <!-- Tombol Produk -->
                  <a href="{{ route('admin-all-produk') }}" class="flex items-center w-full">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m17.578 4.432l-2-1.05C13.822 2.461 12.944 2 12 2s-1.822.46-3.578 1.382l-.321.169l8.923 5.099l4.016-2.01c-.646-.732-1.688-1.279-3.462-2.21m4.17 3.534l-3.998 2V13a.75.75 0 0 1-1.5 0v-2.286l-3.5 1.75v9.44c.718-.179 1.535-.607 2.828-1.286l2-1.05c2.151-1.129 3.227-1.693 3.825-2.708c.597-1.014.597-2.277.597-4.8v-.117c0-1.893 0-3.076-.252-3.978M11.25 21.904v-9.44l-8.998-4.5C2 8.866 2 10.05 2 11.941v.117c0 2.525 0 3.788.597 4.802c.598 1.015 1.674 1.58 3.825 2.709l2 1.049c1.293.679 2.11 1.107 2.828 1.286M2.96 6.641l9.04 4.52l3.411-1.705l-8.886-5.078l-.103.054c-1.773.93-2.816 1.477-3.462 2.21"/></svg>
                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Produk</span>
                  </a>
                  <!-- Toggle Button -->
                  <button type="button" class="w-3 h-3" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                           <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                  </button>
               </div>
               <!-- Dropdown List -->
               <ul id="dropdown-example" class="hidden py-2 space-y-2">
                  <li>
                     <a href="{{ route('admin-all-kategori') }}" class="flex gap-3 items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill="currentColor" d="m6.76 6l.45.89L7.76 8H12v5H4V6zm.62-2H3a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H9l-.72-1.45a1 1 0 0 0-.9-.55m15.38 2l.45.89l.55 1.11H28v5h-8V6zm.62-2H19a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1h-4l-.72-1.45a1 1 0 0 0-.9-.55M6.76 19l.45.89l.55 1.11H12v5H4v-7zm.62-2H3a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1H9l-.72-1.45a1 1 0 0 0-.9-.55m15.38 2l.45.89l.55 1.11H28v5h-8v-7zm.62-2H19a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1h-4l-.72-1.45a1 1 0 0 0-.9-.55"/></svg>
                        Kategori
                     </a>
                  <li>
                     <a href="{{ route('admin-all-unit') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><path fill="currentColor" d="M224 96v120a8 8 0 0 1-8 8H96a8 8 0 0 1-8-8v-48H40a8 8 0 0 1-8-8V40a8 8 0 0 1 8-8h120a8 8 0 0 1 8 8v48h48a8 8 0 0 1 8 8"/></svg>
                        Unit
                     </a>
               </ul>
            </li>
        </ul>

        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
            <li>
               <a href="{{route('admin-user')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M16 17v2H2v-2s0-4 7-4s7 4 7 4m-3.5-9.5A3.5 3.5 0 1 0 9 11a3.5 3.5 0 0 0 3.5-3.5m3.44 5.5A5.32 5.32 0 0 1 18 17v2h4v-2s0-3.63-6.06-4M15 4a3.4 3.4 0 0 0-1.93.59a5 5 0 0 1 0 5.82A3.4 3.4 0 0 0 15 11a3.5 3.5 0 0 0 0-7"/></svg>
                  <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">User</span>
               </a>
            </li>
         </ul>

        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
            <li>
               <a href="{{ route('admin-pengajuan-outlet') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">             
                  <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 1200 1200"><path fill="currentColor" d="M600 0c-65.168 0-115.356 54.372-115.356 119.385c0 62.619-.439 117.407-.439 117.407h-115.87c-2.181 0-4.291.241-6.372.586h-32.227v112.573h540.527V237.378h-32.227c-2.081-.345-4.191-.586-6.372-.586H715.796s1.318-49.596 1.318-117.041C717.114 57.131 665.168 0 600 0M175.195 114.185V1200h849.609V114.185H755.64v78.662h191.382v928.345h-693.97V192.847H444.36v-78.662zM600 115.649c21.35 0 38.599 17.18 38.599 38.452c0 21.311-17.249 38.525-38.599 38.525s-38.599-17.215-38.599-38.525c0-21.271 17.249-38.452 38.599-38.452M329.736 426.27v38.525h38.599V426.27zm115.869.732v38.525h424.658v-38.525zm-115.869 144.58v38.525h38.599v-38.525zm115.869.732v38.599h424.658v-38.599zM329.736 716.895v38.525h38.599v-38.525zm115.869.805v38.525h424.658V717.7zM329.736 862.28v38.525h38.599V862.28zm115.869.806v38.525h424.658v-38.525zm-115.869 144.507v38.525h38.599v-38.525zm115.869.805v38.525h424.658v-38.525z"/></svg>
                  <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Pengajuan</span>
               </a>
            </li>
         </ul>
      </div>

      {{-- LOGOUT --}}
      <div class="w-full">
        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
          <li>
            <form action="{{ route('logout') }}" method="POST" id="logout-form" class="inline">
               @csrf
               <a type="button" id="logout-button" class="cursor-pointer flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="#ff0000" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h7v2H5v14h7v2zm11-4l-1.375-1.45l2.55-2.55H9v-2h8.175l-2.55-2.55L16 7l5 5z"/></svg>
                  <span class="flex-1 ms-3 text-red-600 text-left rtl:text-right whitespace-nowrap">Logout</span>
               </a>
            </form>
          </li>
        </ul>
      </div>
   </div>

   <script>
      document.getElementById('profileImage').addEventListener('click', function() {
      // First alert to confirm if the user wants to edit their profile
      Swal.fire({
         title: "Apakah Anda ingin mengedit profil?",
         showCancelButton: true,
         cancelButtonText: "Tidak",
         confirmButtonText: "Ya",
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
      }).then((result) => {
         if (result.isConfirmed) {
               // If confirmed, ask for the date of birth
               Swal.fire({
                  title: "Masukkan Tanggal Lahir Anda",
                  input: "date",
                  inputAttributes: {
                     autocapitalize: "off"
                  },
                  showCancelButton: true,
                  confirmButtonText: "Masuk",
                  showLoaderOnConfirm: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  allowEnterKey: false,
                  preConfirm: (date) => {
                     const userUID = document.querySelector('p.UID').textContent.trim(); // Get the hidden user ID
                     return verifyLahir(date, userUID).then(isValid => {
                           if (!isValid) {
                              Swal.showValidationMessage('Tanggal lahir salah!');
                           }
                           return isValid;
                     });
                  }
               }).then((passwordResult) => {
                  if (passwordResult.isConfirmed && passwordResult.value) {
                     
                  }
               });
         }
      });
   });

   // Function to verify the date of birth with the server
   function verifyLahir(date, userUID) {
      return new Promise((resolve) => {
         fetch('/verify-date-of-birth', { 
               method: 'POST',
               headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
               },
               body: JSON.stringify({ date: date }) 
         })
         .then(response => {
               if (!response.ok) {
                  throw new Error('Network response was not ok');
               }
               return response.json();
         })
         .then(data => {
               if (data.isValid) {
                  // Redirect to the edit profile route with the user ID
                  window.location.href = `/edit-profile/${userUID}`;
               } else {
                  Swal.showValidationMessage('Tanggal lahir tidak valid, silakan coba lagi.');
               }
               resolve(data.isValid);
         })
         .catch(error => {
               console.error('Error:', error);
               Swal.showValidationMessage('Terjadi kesalahan, silakan coba lagi!');
               resolve(false);
         });
      });
   }
   </script>
</aside>
