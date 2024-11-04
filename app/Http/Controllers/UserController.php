<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Outlet;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    // KONTROL TAMPILAN

    // ADMIN
    // 1. Menampilkan semua user

    public function AdminIndexUser(Request $request)
    {
        $perPage = $request->get('per_page', 10); // Default to 10 items per page
        $selectedRole = $request->get('role'); // Get selected role or null if not selected

        // Start the query for users
        $query = User::query();

        // If a role is selected, filter the query based on role
        if ($selectedRole) {
            $query->where('role', $selectedRole);
        }

        // Paginate the results
        $users = $query->paginate($perPage);

        // Return to the view with the users and selected role for the dropdown
        return view('Admin.user.user-index', [
            'users' => $users,
            'selectedRole' => $selectedRole, // Pass selected role to view for persisting filter state
            'title' => 'Admin User'
        ]);
    }

    // 2. Menampilkan form add user
    public function AdminAddUser()
    {
        return view('Admin.user.add-user', [
            'title' => 'Tambah User'
        ]);
    }

    // 3. Menampilkan form edit user
    public function AdminEditUser($uid)
    {
        $user = User::where('uid', $uid)->firstOrFail();

        $outlet = Outlet::all();

        return view('Admin.user.edit-user', [
            'user' => $user,
            'title' => 'Edit User',
            'outlet' => $outlet,
        ]);
    }

    // PEMILIK 
    // 1. Menampilkan karyawan 
    public function MasterIndexUser(Request $request)
    {
        $user = Auth::user();

        $perPage = $request->get('per_page', 10); // Default to 10 items per page

        // Start the query for users
        $query = User::Where('role', 'Karyawan')
            ->where('id_outlet', $user->id_outlet);

        // Paginate the results
        $users = $query->paginate($perPage);

        // Return to the view with the users and selected role for the dropdown
        return view('Pemilik.user.user-index', [
            'users' => $users,
            'title' => 'Daftar Karyawan'
        ]);
    }

    // 2. Menampilkan form add karyawan
    public function MasterAddUser()
    {
        return view('Pemilik.user.add-user', [
            'title' => 'Tambah Karyawan'
        ]);
    }

    // 3. Menampilkan form edit karyawan
    public function MasterEditUser($uid)
    {
        $user = User::where('uid', $uid)->firstOrFail();

        return view('Pemilik.user.edit-user', [
            'user' => $user,
            'title' => 'Edit Karyawan ' . $user->username,
        ]);
    }


    // QUERY USER MANAJEMEN 

    // ADMIN
    // 1. Menambahkan user baru

    public function AdminStoreUser(Request $request)
    {
        // Validate the input
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            'role' => 'required',
            'no_telp' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg',
            'status' => 'required',
        ]);

        if ($validation->fails()) {
            // Check if the email already exists
            if ($request->filled('email') && User::where('email', $request->email)->exists()) {
                return redirect()->back()->withErrors([
                    'email' => 'Email sudah ada, silakan gunakan email lain.'
                ])->withInput();
            }

            // General validation error message
            return redirect()->back()->withErrors([
                'error' => 'Tambah user error, coba ulang lagi.'
            ])->withInput();
        }

        // MENYIMPAN GAMBAR 
        if ($request->hasFile('foto')) {
            // Mengambil file gambar
            $foto = $request->file('foto');

            // Menghasilkan nama file unik berdasarkan timestamp
            $filename = time() . '.' . $foto->extension();

            // Menyimpan file ke dalam storage/app/public/assets folder
            $foto->storeAs('assets/profile', $filename);

        } else {
            $filename = null;
        }

        // MENAMBAH USER
        $user = new User();
        $user->uid = $this->generateUid();
        $user->name = $request->name;
        $user->role = $request->role;
        $user->no_telp = $request->no_telp;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->password = Hash::make($request->password);
        $user->alamat = $request->alamat;
        $user->status = $request->status;

        // MENAMBAH  FOTO
        $user->foto = $filename ? 'profile/' . $filename : null;

        $user->save();

        return redirect()->route('admin-user')->with('success', 'User Berhasil Ditambah!.');
    }

    // 2. Mengupdate user
    public function AdminUpdateUser(Request $request, $uid)
    {
        // Validasi permintaan
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'no_telp' => 'required|string',
            'username' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'status' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg',
            'id_outlet' => 'nullable|exists:outlet,id',
        ]);

        if ($validation->fails()) {
            // Check if the email already exists
            if ($request->filled('email') && User::where('email', $request->email)->exists()) {
                return redirect()->back()->withErrors([
                    'email' => 'Email sudah ada, silakan gunakan email lain.'
                ])->withInput();
            }

            // General validation error message
            return redirect()->back()->withErrors([
                'error' => 'Update error, pastikan semua terisi dengan benar.'
            ])->withInput();
        }

        $user = User::where('uid', $uid)->firstOrFail();

        // MENYIMPAN GAMBAR
        if ($request->hasFile('foto')) {
            // Mengambil file gambar
            $foto = $request->file('foto');

            // Menghasilkan nama file unik berdasarkan timestamp
            $filename = time() . '.' . $foto->extension();

            if ($user->foto) {
                // Hapus file dari storage dengan path yang sesuai
                Storage::disk('public')->delete('assets/profile/' . basename($user->foto));
            }

            // Menyimpan file ke dalam storage/app/public/assets/profile folder
            $foto->storeAs('assets/profile', $filename, 'public');

            // Simpan path baru ke database
            $user->foto = 'profile/' . $filename;
        } else {
            // Jika tidak ada gambar baru yang diunggah, jangan mengubah path foto
            $filename = $user->foto;
        }

        // Perbarui atribut user
        $user->name = $request->name;
        $user->no_telp = $request->no_telp;
        $user->username = $request->username;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->alamat = $request->alamat;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->id_outlet = $request->id_outlet;
        $user->status = $request->status;

        if ($request->status === 'Berhenti') {
            $user->id_outlet = null; // Set id_outlet to NULL if user is not working
        } else {
            $user->id_outlet = $request->id_outlet; // Assign selected outlet if working
        }

        $user->save();


        return redirect()->route('admin-user')->with('success', 'User Berhasil Diupdate');


        // return $request;
    }

    // PEMILIK 
    // 1. Menambah karyawan
    public function MasterStoreUser(Request $request)
    {
        // Validate the input
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            'no_telp' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg',
            'status' => 'required',
        ]);


        if ($validation->fails()) {
            // Check if the email already exists
            if ($request->filled('email') && User::where('email', $request->email)->exists()) {
                return redirect()->back()->withErrors([
                    'email' => 'Email sudah ada, silakan gunakan email lain.'
                ])->withInput();
            }

            // General validation error message
            return redirect()->back()->withErrors([
                'error' => 'Tambah user error, coba ulang lagi.'
            ])->withInput();
        }

        // MENYIMPAN GAMBAR 
        if ($request->hasFile('foto')) {
            // Mengambil file gambar
            $foto = $request->file('foto');

            // Menghasilkan nama file unik berdasarkan timestamp
            $filename = time() . '.' . $foto->extension();

            // Menyimpan file ke dalam storage/app/public/assets folder
            $foto->storeAs('assets/profile', $filename);

        } else {
            $filename = null;
        }

        $IdOutlet = Auth::user()->id_outlet;

        // MENAMBAH USER
        $user = new User();
        $user->uid = $this->generateUid();
        $user->name = $request->name;
        $user->id_outlet = $IdOutlet;
        $user->role = 'Karyawan';
        $user->no_telp = $request->no_telp;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->password = Hash::make($request->password);
        $user->alamat = $request->alamat;
        $user->status = $request->status;

        // MENAMBAH  FOTO
        $user->foto = $filename ? 'profile/' . $filename : null;

        $user->save();

        return redirect()->route('pemilik-karyawan')->with('success', 'Karyawan Berhasil Ditambah!.');
    }

    // 2. Mengupdate user
    public function MasterUpdateUser(Request $request, $uid)
    {
        // Validasi permintaan
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'no_telp' => 'required|string',
            'username' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'status' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        if ($validation->fails()) {
            // Check if the email already exists
            if ($request->filled('email') && User::where('email', $request->email)->exists()) {
                return redirect()->back()->withErrors([
                    'email' => 'Email sudah ada, silakan gunakan email lain.'
                ])->withInput();
            }

            // General validation error message
            return redirect()->back()->withErrors([
                'error' => 'Update error, pastikan semua terisi dengan benar.'
            ])->withInput();
        }

        $user = User::where('uid', $uid)->firstOrFail();

        // MENYIMPAN GAMBAR
        if ($request->hasFile('foto')) {
            // Mengambil file gambar
            $foto = $request->file('foto');

            // Menghasilkan nama file unik berdasarkan timestamp
            $filename = time() . '.' . $foto->extension();

            if ($user->foto) {
                // Hapus file dari storage dengan path yang sesuai
                Storage::disk('public')->delete('assets/profile/' . basename($user->foto));
            }

            // Menyimpan file ke dalam storage/app/public/assets/profile folder
            $foto->storeAs('assets/profile', $filename, 'public');

            // Simpan path baru ke database
            $user->foto = 'profile/' . $filename;
        } else {
            // Jika tidak ada gambar baru yang diunggah, jangan mengubah path foto
            $filename = $user->foto;
        }

        // Perbarui atribut user
        $user->name = $request->name;
        $user->no_telp = $request->no_telp;
        $user->username = $request->username;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->alamat = $request->alamat;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->status = $request->status;

        $user->save();


        return redirect()->route('pemilik-karyawan')->with('success', 'Karyawan Berhasil Diupdate');


        // return $request;
    }

    // PEMILIK DAN ADMIN
    // 1. Membuat UID
    function generateUid()
    {
        // Menghasilkan 2 huruf kapital acak
        $letters = strtoupper(Str::random(2));

        // Menghasilkan 3 angka acak
        $numbers = rand(000, 999);

        // Menggabungkan huruf dan angka
        return $letters . $numbers;
    }

    // 2. Mengganti status user 
    public function UserStatusUpdate($uid)
    {
        $role = Auth::user()->role;
        // Mencari user berdasarkan UID
        $user = User::where('uid', $uid)->firstOrFail();

        // Pastikan bahwa role user adalah Admin atau User, lalu lakukan perubahan status
        if ($user) {
            // Jika status user saat ini adalah 'Aktif' atau 'Bekerja', maka ganti menjadi 'Berhenti'
            if ($user->status == 'Aktif' || $user->status == 'Bekerja') {
                $user->status = 'Nonaktif';
            }
            // Jika status user selain 'Aktif' atau 'Bekerja', ganti menjadi 'Aktif'
            else {
                if ($user->role == 'Admin' || $user->role == 'User') {
                    $user->status = 'Aktif';
                } else {
                    $user->status = 'Bekerja';
                }
            }

            // Simpan perubahan status ke database
            $user->save();

            if ($role == 'Admin') {
                return redirect()->route('admin-user')->with('success', 'Status user berhasil diubah.');
            } else {
                return redirect()->route('pemilik-karyawan')->with('success', 'Status karyawan berhasil diubah.');
            }
        }

        if ($role == 'Admin') {
            // Jika role tidak sesuai, berikan pesan error
            return redirect()->route('admin-user')->with('error', 'Pengguna Anomali');
        } else {
            return redirect()->route('pemilik-karyawan')->with('error', 'Pengguna Anomali');
        }

    }

    // 3. Menghapus user
    public function DestroyUser($uid)
    {
        $role = Auth::user()->role;

        // Mencari pengguna berdasarkan UID
        $user = User::where('uid', $uid)->firstOrFail();

        // Hapus gambar pengguna jika ada
        if ($user->foto && Storage::exists('assets/' . $user->foto)) {
            // Menghapus file gambar dari storage
            Storage::delete('assets/' . $user->foto);
        }

        // Hapus pengguna dari database
        $user->delete();

        if ($role == 'Admin') {
            return redirect()->route('admin-user')->with('success', 'User dan foto berhasil dihapus');

        } else {
            return redirect()->route('pemilik-karyawan')->with('success', 'User dan foto berhasil dihapus');
        }
    }


    // ALL USER 
    // 1. Update Profile
    public function UpdateProfile(Request $request, $uid)
    {
        // Validate input fields
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'no_telp' => 'required|string',
            'username' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'status' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        // Get authenticated user
        $user = User::where('uid', $uid)->firstOrFail();

        // MENYIMPAN GAMBAR
        if ($request->hasFile('foto')) {
            // Mengambil file gambar
            $foto = $request->file('foto');

            // Menghasilkan nama file unik berdasarkan timestamp
            $filename = time() . '.' . $foto->extension();

            if ($user->foto) {
                // Hapus file dari storage dengan path yang sesuai
                Storage::disk('public')->delete('assets/profile/' . basename($user->foto));
            }

            // Menyimpan file ke dalam storage/app/public/assets/profile folder
            $foto->storeAs('assets/profile', $filename, 'public');

            // Simpan path baru ke database
            $user->foto = 'profile/' . $filename;
        } else {
            // Jika tidak ada gambar baru yang diunggah, jangan mengubah path foto
            $filename = $user->foto;
        }

        // Perbarui atribut user
        $user->name = $request->name;
        $user->no_telp = $request->no_telp;
        $user->username = $request->username;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->alamat = $request->alamat;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->status = $request->status;

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }





}
