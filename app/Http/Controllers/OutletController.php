<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Outlet;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OutletController extends Controller
{
    // KONTROL TAMPILAN 

    // ADMIN KONTROLLER
    // 1. Menampilkan semua outlet

    public function AdminIndexOutlet(Request $request)
    {
        $perPage = $request->get('per_page', 10); // Default to 10 items per page
        $selectedRole = $request->get('role'); // Get selected role or null if not selected

        // Start the query for users
        $query = Outlet::query();

        // If a role is selected, filter the query based on role
        // if ($selectedRole) {
        //     $query->where('role', $selectedRole);
        // }

        // Paginate the results
        $outlets = $query->paginate($perPage);

        // Return to the view with the users and selected role for the dropdown
        return view('Admin.outlet.outlet-index', [
            'outlets' => $outlets,
            // 'selectedRole' => $selectedRole, // Pass selected role to view for persisting filter state
            'title' => 'Admin Outlet'
        ]);
    }

    // 2. Halaman tambah outlet
    public function AdminAddOutlet()
    {
        $users = User::where('role', 'Master')
            ->where('status', 'Bekerja')
            ->get();

        return view('Admin.outlet.add-outlet', [
            'title' => 'Tambah Outlet',
            'users' => $users,
        ]);
    }

    // 3. Halaman edit outlet
    public function AdminEditOutlet($uid)
    {
        $outlet = Outlet::where('uid', $uid)->firstOrFail();

        $user = User::where('role', 'Master')->where('status', 'Bekerja')->get();

        return view('Admin.outlet.edit-outlet', [
            'users' => $user,
            'title' => 'Edit Outlet',
            'outlet' => $outlet,
        ]);
    }

    //  QUERY OUTLET MANAJEMENT

    // ADMIN KONTROLLER
    // 1. Random uid outlet

    function generateUid()
    {
        // Menghasilkan 2 huruf kapital acak
        $letters = strtoupper(Str::random(2));

        // Menghasilkan 3 angka acak
        $numbers = rand(000, 999);

        // Menggabungkan huruf dan angka
        return $letters . $numbers;
    }
    // 2. Menambah outlet
    public function AdminStoreOutlet(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nama_outlet' => 'required|string',
            'no_telp' => 'nullable|string|max:20',
            'pin' => 'nullable|string|min:4',
            'email' => 'required|email|max:255|unique:outlet,email',
            'pemilik' => 'nullable|string',
            'alamat' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg',
            'jam_buka' => 'nullable',
            'jam_tutup' => 'nullable',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validation->fails()) {
            if ($request->filled('email') && Outlet::where('email', $request->email)->exists()) {
                return redirect()->back()->withErrors([
                    'email' => 'Email sudah ada, silakan gunakan email lain.'
                ])->withInput();
            }

            // General validation error message
            return redirect()->back()->withErrors([
                'error' => 'Tambah outlet error, pastikan semua data terisi dengan benar'
            ])->withInput();
        }

        // MENYIMPAN GAMBAR 
        if ($request->hasFile('foto')) {
            // Mengambil file gambar
            $foto = $request->file('foto');

            // Menghasilkan nama file unik berdasarkan timestamp
            $filename = time() . '.' . $foto->extension();

            // Menyimpan file ke dalam storage/app/public/assets folder
            $foto->storeAs('assets/outlet', $filename);

        } else {
            $filename = null;
        }

        $outlet = new Outlet();
        $outlet->uid = $this->generateUid();
        $outlet->nama_outlet = $request->nama_outlet;
        $outlet->no_telp = $request->no_telp;
        $outlet->email = $request->email;
        $outlet->pin = $request->pin;
        $outlet->pemilik = $request->pemilik;
        $outlet->instagram = $request->instagram;
        $outlet->facebook = $request->facebook;
        $outlet->tiktok = $request->tiktok;
        $outlet->alamat = $request->alamat;
        // MENAMBAH  FOTO
        $outlet->foto = $filename ? 'outlet/' . $filename : null;

        $outlet->jam_buka = $request->jam_buka;
        $outlet->jam_tutup = $request->jam_tutup;
        $outlet->deskripsi = $request->deskripsi;
        $outlet->status = 'Aktif';

        $outlet->save();

        return redirect()->route('admin-all-outlet')->with('success', 'Outlet Berhasil Ditambah');
    }

    // 3. Menghapus outlet
    public function AdminDestroyOutlet($uid)
    {
        // Mencari outlet berdasarkan UID
        $outlet = Outlet::where('uid', $uid)->firstOrFail();

        if ($outlet) {
            // HAPUS PRODUK OUTLET
            $produks = $outlet->Produk; // Ambil semua produk terkait

            // Cek apakah ada produk yang terkait
            if ($produks->isNotEmpty()) {
                // Jika ada produk, hapus semua produk
                foreach ($produks as $produk) {
                    // Hapus gambar produk jika ada
                    if ($produk->foto && Storage::exists('assets/' . $produk->foto)) {
                        // Menghapus file gambar produk dari storage
                        Storage::delete('assets/' . $produk->foto);
                    }
                    // Hapus produk dari database
                    $produk->delete();
                }
            }

            // HAPUS KATEGORI OUTLET
            $kategoris = $outlet->Kategori; // Ambil semua kategori terkait

            if ($kategoris->isNotEmpty()) {
                foreach ($kategoris as $kategori) {
                    $kategori->delete(); // Hapus kategori dari database
                }
            }

            // HAPUS UNIT OUTLET
            $units = $outlet->Unit; // Ambil semua unit terkait

            if ($units->isNotEmpty()) {
                foreach ($units as $unit) {
                    $unit->delete(); // Hapus unit dari database
                }
            }

            // UPDATE USER
            $users = $outlet->User; // Ambil semua user terkait

            if ($users->isNotEmpty()) {
                foreach ($users as $user) {
                    // Jika role user adalah 'Karyawan', ubah menjadi 'User'
                    if ($user->role == 'Karyawan') {
                        $user->role = 'User';
                        $user->status = 'Aktif';
                    }
                    
                    // Set id_outlet menjadi null
                    $user->id_outlet = null;

                    // Simpan perubahan pada user
                    $user->save();
                }
            }

            // Hapus gambar outlet jika ada
            if ($outlet->foto && Storage::exists('assets/' . $outlet->foto)) {
                // Menghapus file gambar dari storage
                Storage::delete('assets/' . $outlet->foto);
            }

            // Hapus outlet dari database
            $outlet->delete();
        }

        // Redirect atau berikan respon setelah berhasil menghapus
        return redirect()->route('admin-all-outlet')->with('success', 'Outlet, produk dan foto berhasil dihapus');
    }

    // 4. Mengganti status Outlet 
    public function AdminStatusOutletUpdate($uid)
    {
        // Mencari outlet berdasarkan UID
        $outlet = Outlet::where('uid', $uid)->firstOrFail();

        // Pastikan bahwa role outlet adalah Admin atau User, lalu lakukan perubahan status
        if ($outlet) {
            // Jika status outlet saat ini adalah 'Aktif' atau 'Bekerja', maka ganti menjadi 'Berhenti'
            if ($outlet->status == 'Aktif') {
                $outlet->status = 'Nonaktif';
            }
            // Jika status outlet selain 'Aktif' atau 'Bekerja', ganti menjadi 'Aktif'
            else {
                $outlet->status = 'Aktif';
            }

            // Simpan perubahan status ke database
            $outlet->save();

            // Redirect atau berikan pesan setelah update berhasil
            return redirect()->route('admin-all-outlet')->with('success', 'Status outlet berhasil diubah.');
        }

        // Jika role tidak sesuai, berikan pesan error
        return redirect()->route('admin-all-outlet')->with('error', 'Outlet Anomali');
    }


    // PEMILIK KONTROLLER 
    // 1. Edit Outlet
    public function MasterEditOutlet($uid){
        $outlet = Outlet::where('uid', $uid)->firstOrFail();

        return view('Pemilik.edit-outlet', [
            'title' => 'Edit Outlet',
            'outlet' => $outlet,
        ]);
    }


    // PEMILIK DAN ADMIN KONTROLLER 
    // 1. Mengupdate outlet
    public function UpdateOutlet(Request $request, $uid)
    {
        $outlet = Outlet::where('uid', $uid)->firstOrFail();
        // Validasi permintaan
        $validation = Validator::make($request->all(), [
            'nama_outlet' => 'required|string',
            'no_telp' => 'nullable|string|max:20',
            'pin' => 'nullable|string|max:4',
            'email' => 'required|email|max:255',
            'pemilik' => 'nullable|string',
            'alamat' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg',
            'jam_buka' => 'nullable',
            'jam_tutup' => 'nullable',
            'deskripsi' => 'nullable',
            'status' => 'nullable',
        ]);

        if ($validation->fails()) {
            if ($request->filled('email') && Outlet::where('email', $request->email)->exists()) {
                return redirect()->back()->withErrors([
                    'email' => 'Email sudah ada, silakan gunakan email lain.'
                ])->withInput();
            }

            // General validation error message
            return redirect()->back()->withErrors([
                'error' => 'Edit outlet error, pastikan semua data terisi terisi dengan benar!'
            ])->withInput();
        }

        // MENYIMPAN GAMBAR
        if ($request->hasFile('foto')) {
            // Mengambil file gambar
            $foto = $request->file('foto');

            // Menghasilkan nama file unik berdasarkan timestamp
            $filename = time() . '.' . $foto->extension();

            if ($outlet->foto) {
                // Hapus file dari storage dengan path yang sesuai
                Storage::disk('public')->delete('assets/outlet/' . basename($outlet->foto));
            }

            // Menyimpan file ke dalam storage/app/public/assets/profile folder
            $foto->storeAs('assets/outlet', $filename, 'public');

            // Simpan path baru ke database
            $outlet->foto = 'outlet/' . $filename;
        } else {
            // Jika tidak ada gambar baru yang diunggah, jangan mengubah path foto
            $filename = $outlet->foto;
        }


        // Perbarui atribut outlet
        $outlet->nama_outlet = $request->nama_outlet;
        $outlet->no_telp = $request->no_telp;
        $outlet->email = $request->email;
        $outlet->pin = $request->pin;
        $outlet->pemilik = $request->pemilik;
        $outlet->alamat = $request->alamat;
        $outlet->instagram = $request->instagram;
        $outlet->facebook = $request->facebook;
        $outlet->tiktok = $request->tiktok;
        $outlet->status = $request->status;
        $outlet->jam_buka = $request->jam_buka;
        $outlet->jam_tutup = $request->jam_tutup;
        $outlet->deskripsi = $request->deskripsi;
        $outlet->save();


        if (Auth::user()->role == 'Admin') {
            return redirect()->route('admin-all-outlet')->with('success', 'Outlet berhasil diupdate');
        } else {
            return redirect()->route('pemilik-dashboard')->with('success', 'Outlet berhasil diupdate');
        }
    }







}
