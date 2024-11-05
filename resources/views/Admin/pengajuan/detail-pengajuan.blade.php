<x-admin-layout :title="$title">
    <div class="w-full p-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form id="approve-form" action="{{ route('admin-approve-pengajuan', $pengajuan->id) }}" method="POST" class="inline" enctype="multipart/form-data">
        @csrf
            <h2 class="text-3xl font-semibold text-gray-800 dark:text-white border-b-2 border-gray-200 pb-2 mb-4">Detail Pengajuan</h2>
            {{-- DATA PEMILIK --}}
            <div class="flex flex-col md:flex-row gap-4 mt-5">
                <div class="w-full lg:w-1/2 bg-gray-50 p-4 rounded-lg shadow-md h-auto">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white border-b-2 border-gray-200 pb-2 mb-4">Data Pemilik</h2>
                    <ul class="space-y-4 text-gray-600 dark:text-gray-400">
                        <li class="flex justify-between">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Nama:</span>
                            <span>{{ $pengajuan->User->name }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Email:</span>
                            <span>{{ $pengajuan->User->email }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Telepon:</span>
                            <span>{{ $pengajuan->User->no_telp }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Alamat:</span>
                            <span>{{ $pengajuan->User->alamat }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Tanggal Lahir:</span>
                            <span>{{ $pengajuan->User->tanggal_lahir }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Jenis Kelamin:</span>
                            <span>{{ $pengajuan->User->jenis_kelamin }}</span>
                        </li>
                    </ul>
                </div>
                {{-- Foto Pemilik --}}
                <div class="w-full lg:w-1/2 bg-gray-50 p-4 rounded-lg shadow-md">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white border-b-2 border-gray-200 pb-2 mb-4">Foto Pemilik</h2>
                    <div class="grid grid-cols-1 gap-4">
                        @if ($pengajuan->User->foto && Storage::exists('assets/' . $pengajuan->User->foto))
                            <img class="mx-auto w-1/2 object-contain h-auto rounded-md" src="{{ Storage::url('app/public/assets/' . $pengajuan->User->foto) }}" alt="User">
                        @else
                            @if ($pengajuan->User->jenis_kelamin === 'Laki-laki')
                                <img class="mx-auto w-1/2 object-contain h-auto rounded-md" src="{{ asset('public/assets/icon-male.png') }}" alt="User">
                            @elseif ($pengajuan->User->jenis_kelamin === 'Perempuan')
                                <img class="mx-auto w-1/2 object-contain h-auto rounded-md" src="{{ asset('public/assets/icon-female.png') }}" alt="User">
                            @else
                            <img class="mx-auto w-1/2 object-contain h-auto rounded-md" src="{{ asset('public/assets/icon-profile.png') }}" alt="User">
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            
            {{-- DATA OUTLET --}}
            <div class="flex flex-col md:flex-row gap-4 mt-5">
                {{-- Informasi Outlet --}}
                <div class="w-full lg:w-1/2 bg-gray-50 p-4 rounded-lg shadow-md h-auto flex flex-col">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white border-b-2 border-gray-200 pb-2 mb-4">Data Outlet</h2>
                    <ul class="space-y-4 text-gray-600 dark:text-gray-400 flex-grow">
                        <li class="flex justify-between">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Nama Outlet:</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $pengajuan->nama_outlet }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Alamat Outlet:</span>
                            <span class="font-semibold text-right text-gray-800 dark:text-gray-200">{{ $pengajuan->alamat }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Status Pengajuan:</span>
                            <span class="inline-block text-base font-bold rounded-lg px-3 py-1
                                {{ $pengajuan->status == 'Approved' ? 'bg-green-200 text-green-900' :
                                ($pengajuan->status == 'Rejected' ? 'bg-red-200 text-red-900' :
                                    ($pengajuan->status == 'Pending' ? 'bg-gray-200 text-gray-900' : '')) }}">
                                {{ $pengajuan->status }}
                            </span>
                        </li>
                        <li class="">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Deskripsi Outlet:</span>
                            <div class="p-3 bg-white rounded-lg w-full" style="background: white">
                                <p class="font-semibold text-left text-gray-800 dark:text-gray-200">{{ $pengajuan->deskripsi }}</p>
                            </div>
                        </li>
                    </ul>

                    {{-- Social Media Buttons --}}
                    <div class="flex flex-col md:flex-row gap-4 mt-2 md:mt-auto items-start content-start justify-start">
                        <a href="{{ $pengajuan->instagram ? 'https://www.instagram.com/' . $pengajuan->instagram : 'javascript:void(0);' }}" 
                        target="{{ $pengajuan->instagram ? '_blank' : '' }}" 
                        style="display: flex; align-items: center; padding: 0.625rem 0.5rem; font-size: 0.875rem; font-weight: 500; color: white; background: linear-gradient(to right, #833AB4, #FD1D1D, #FDCB58); border-radius: 0.5rem; transition: opacity 0.3s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'"  class="flex items-center px-2 py-2.5 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg {{ $pengajuan->instagram ? '' : 'cursor-not-allowed' }}" {{ $pengajuan->instagram ? '' : 'disabled' }} 
                        onclick="{{ $pengajuan->instagram ? '' : 'event.preventDefault();' }}">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4zm9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8A1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5a5 5 0 0 1-5 5a5 5 0 0 1-5-5a5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3"/>
                            </svg>
                            {{ $pengajuan->instagram ? '@' . $pengajuan->instagram : 'Instagram' }}
                        </a>

                        <a href="{{ $pengajuan->facebook ? 'https://www.facebook.com/' . $pengajuan->facebook : 'javascript:void(0);' }}" 
                        class="flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow hover:shadow-lg transition duration-200 {{ $pengajuan->facebook ? '' : 'cursor-not-allowed' }}" 
                        onclick="{{ $pengajuan->facebook ? '' : 'event.preventDefault();' }}">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
                                <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
                            </svg>
                            {{ $pengajuan->facebook ?: 'Facebook' }}
                        </a>

                        <a href="{{ $pengajuan->tiktok ? 'https://www.tiktok.com/@' . $pengajuan->tiktok . '?lang=id-ID' : 'javascript:void(0);' }}" 
                        class="flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-800 rounded-lg shadow hover:shadow-lg transition duration-200 {{ $pengajuan->tiktok ? '' : 'cursor-not-allowed' }}" 
                        onclick="{{ $pengajuan->tiktok ? '' : 'event.preventDefault();' }}">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                <path fill="#ffffff" stroke="#ffffff" stroke-linejoin="round" stroke-width="3.83" d="M21.358 19.14q-8.833-.426-12.28 6.298c-3.446 6.725-.598 17.729 10.9 17.729c11.5 0 11.832-11.112 11.832-12.276V17.875q3.69 2.336 6.22 2.813q2.533.476 3.22.422v-6.476q-2.342-.282-4.05-1.076c-1.709-.794-5.096-2.997-5.096-6.226q.003.024 0-2.499h-7.118q-.031 23.724 0 26.058c.031 2.334-1.78 5.6-5.45 5.6c-3.672 0-5.483-3.263-5.483-5.367c0-1.288.443-3.155 2.272-4.538c1.085-.82 2.59-1.148 3.178-1.148z"></path>
                            </svg>
                            {{ $pengajuan->tiktok ? '@' . $pengajuan->tiktok : 'TikTok' }}
                        </a>
                    </div>
                </div>


                {{-- Foto Outlet --}}
                <div class="w-full lg:w-1/2 bg-gray-50 p-4 rounded-lg shadow-md">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white border-b-2 border-gray-200 pb-2 mb-4">Foto Outlet</h2>
                    <div class="grid grid-cols-1 gap-4">
                        <a target="_blank" class="">
                            @if ($pengajuan->foto && Storage::exists('assets/' . $pengajuan->foto))
                                <img class="mx-auto w-1/2 object-contain h-auto rounded-md" src="{{ Storage::url('app/public/assets/' . $pengajuan->foto) }}" alt="Outlet">
                            @else
                                <img class="mx-auto w-1/2 object-contain h-auto rounded-md" src="{{ asset('public/assets/icon-outlet.png') }}" alt="Outlet">
                            @endif
                        </a>
                    </div>
                </div>
            </div>

            {{-- BUTTON --}}
            <div class="mt-8 flex justify-end gap-2">
                <a href="{{ route('admin-pengajuan-outlet') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-700 transition duration-200">Kembali</a>

                @if ($pengajuan->status !== 'Rejected')
                    <button type="button" id="setuju-button" class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition duration-200">Setuju</button>
                @endif
            </div>
        </form>
    </div>

    <script>
        document.getElementById('setuju-button').addEventListener('click', function() {
            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah Anda yakin ingin menyetujui pengajuan ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, setuju!',
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the form via AJAX
                    const form = document.getElementById('approve-form');
                    const formData = new FormData(form); // Create FormData object from the form

                    fetch(form.action, {
                        method: 'POST', // Use the appropriate method
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Add CSRF token for Laravel
                        },
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Approve!',
                                text: 'Pengajuan disetujui!',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#3085d6',
                            }).then(() => {
                                window.location.href = '{{ route('admin-pengajuan-outlet') }}';  // Reload setelah sukses
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message || 'Gagal menyetujui pengajuan.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#3085d6',
                            });
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Proses error',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3085d6',
                        });
                    });
                }
            });
        });

    </script>
</x-admin-layout>
