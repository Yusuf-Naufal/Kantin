<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Outlet;
use App\Models\Pengajuan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PengajuanController extends Controller
{
    // KONTROL TAMPILAN

    // ADMIN KONTROL
    // 1. Daftar Pengajuan

    public function AdminPengajuan(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $status = $request->get('status');

        $query = Pengajuan::query();

        // Apply status filter if provided
        if ($status) {
            $query->where('status', $status);
        }

        $pengajuan = $query->paginate($perPage);

        return view('Admin.pengajuan.pengajuan-index', [
            'title' => 'Admin Outlet',
            'pengajuans' => $pengajuan,
        ]);
    }

    // 2. Detail Pengajuan 
    public function AdminDetailPengajuan($id)
    {
        // Ambil data pengajuan beserta data pemilik dan outlet terkait
        $pengajuan = Pengajuan::with('User')->findOrFail($id);

        // Tampilkan view detail pengajuan dengan data yang didapat
        return view('Admin.pengajuan.detail-pengajuan', [
            'title' => 'Detail Outlet '.$pengajuan->nama_outlet,
            'pengajuan' => $pengajuan,
        ]);
    }

    // PEMILIK KONTROL
    // 1.Registrasi Outlet

    public function RegisterOutlet()
    {
        // Mendapatkan ID pengguna yang sedang login
        $userId = Auth::user()->id;

        // Mencari pengajuan berdasarkan id_pemilik yang sedang login
        $pengajuan = Pengajuan::where('id_user', $userId)->first();

        // Cek apakah pengajuan ada dan statusnya 'Pending'
        if ($pengajuan) {
            if ($pengajuan->status === 'Pending') {
                // Menampilkan status pending
                return view('register-outlet', [
                    'status' => 'pending',
                    'pengajuan' => $pengajuan
                ]);
            } elseif ($pengajuan->status === 'Rejected') {
                // Menampilkan status ditolak
                return view('register-outlet', [
                    'status' => 'rejected',
                    'pengajuan' => $pengajuan
                ]);
            } else {
                // Menampilkan status belum ada (untuk status lain)
                return view('register-outlet', [
                    'status' => 'null',
                    'pengajuan' => $pengajuan
                ]);
            }
        }


        // Menampilkan form pendaftaran outlet
        return view('register-outlet', ['status' => 'register']);
    }


    // MANAJEMEN QUERY

    // ADMIN KONTROL
    // 1. Tolak Pengajuan 

    public function AdminRejectPengajuan($id)
    {
        // Find the application
        $pengajuan = Pengajuan::findOrFail($id);

        // Update status to "Rejected"
        $pengajuan->status = 'Rejected';
        $pengajuan->save();


        // Redirect back with success message
        return response()->json(['success' => true, 'message' => 'Pengajuan ditolak!']);
    }

    // 2. Hapus Pengajuan
    public function AdminDestroyPengajuan($id)
    {
        // Find the application
        $pengajuan = Pengajuan::findOrFail($id);

        if($pengajuan){
            // Hapus gambar outlet jika ada
            if ($pengajuan->foto && Storage::exists('assets/' . $pengajuan->foto)) {
                // Menghapus file gambar dari storage
                Storage::delete('assets/' . $pengajuan->foto);
            }

            $pengajuan->delete();
        }


        // Redirect back with success message
        return response()->json(['success' => true, 'message' => 'Pengajuan berhasil dihapus!']);
    }

    public function AdminApprovePengajuan($id)
    {
        // Temukan pengajuan
        $pengajuan = Pengajuan::findOrFail($id);

        if ($pengajuan) {
            // Persiapkan data untuk dimasukkan ke tabel outlet
            $outletData = [
                'uid' => $this->generateUniqueUid(), // Pastikan UID unik
                'nama_outlet' => $pengajuan->nama_outlet,
                'pemilik' => $pengajuan->User->name,
                'no_telp' => $pengajuan->no_telp,
                'email' => $pengajuan->email,
                'pin' => $pengajuan->pin,
                'alamat' => $pengajuan->alamat,
                'instagram' => $pengajuan->instagram,
                'tiktok' => $pengajuan->tiktok,
                'facebook' => $pengajuan->facebook,
                'status' => 'Aktif',
                'jam_buka' => $pengajuan->jam_buka,
                'jam_tutup' => $pengajuan->jam_tutup,
                'deskripsi' => $pengajuan->deskripsi,
                'foto' => $pengajuan->foto,
            ];

            // Simpan ke tabel outlet
            try {
                //Simpan outlet data terlebih dahulu
                $outlet = Outlet::create($outletData);

                // Update id_outlet untuk pengguna
                User::where('email', $pengajuan->User->email)->update([
                    'id_outlet' => $outlet->id,
                    'status' => 'Bekerja',
                    'role' => 'Master',
                ]);

                // Hapus pengajuan setelah semua proses berhasil
                $pengajuan->delete();

                // Redirect back with success message
                return response()->json(['success' => true, 'message' => 'Pengajuan disetujui dan outlet berhasil ditambahkan.']);
            } catch (\Exception $e) {
                // Tangani kesalahan saat menyimpan outlet
                return response()->json(['success' => false, 'message' => 'Gagal menambahkan outlet: ' . $e->getMessage()]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Pengajuan tidak ditemukan.']);
    }
    function generateUniqueUid()
    {
        do {
            $uid = $this->generateUid();
            Log::info('Generated UID: ' . $uid);
        } while (Outlet::where('uid', $uid)->exists());

        return $uid;
    }

    // Fungsi generateUid yang sudah ada
    private function generateUid()
    {
        // Menghasilkan 2 huruf kapital acak
        $letters = strtoupper(Str::random(2));
        // Menghasilkan 3 angka acak
        $numbers = rand(0, 999); // Pastikan angka dihasilkan dari 0-999
        // Menggabungkan huruf dan angka
        return $letters . str_pad($numbers, 3, '0', STR_PAD_LEFT); // Pastikan angka selalu 3 digit
    }







    // PEMILIK KONTROL
    // 1.Menambah Pengajuan

    public function MasterStorePengajuan(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nama_outlet' => 'required|string|max:255',
            'no_telp' => 'nullable|string|max:20',
            'pin' => 'nullable|string|min:4',
            'email' => 'nullable|email|max:255',
            'alamat' => 'required|string|max:255',
            'id_user' => 'required|exists:users,id',
            'deskripsi' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg',
            'jam_buka' => 'nullable',
            'jam_tutup' => 'nullable', // Validate image
        ]);

        if ($validation->fails()) {
            if ($request->filled('email') && Outlet::where('email', $request->email)->exists()) {
                return redirect()->back()->withErrors([
                    'email' => 'Email sudah ada, silakan gunakan email lain.'
                ])->withInput();
            }

            // General validation error message
            return redirect()->back()->withErrors([
                'error' => 'Pengajuan error, coba ulang lagi.'
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

        $outlet = new Pengajuan();
        $outlet->nama_outlet = $request->nama_outlet;
        $outlet->no_telp = $request->no_telp;
        $outlet->email = $request->email;
        $outlet->pin = $request->pin;
        $outlet->id_user = $request->id_user;
        $outlet->instagram = $request->instagram;
        $outlet->facebook = $request->facebook;
        $outlet->tiktok = $request->tiktok;
        $outlet->alamat = $request->alamat;
        $outlet->foto = $filename ? 'outlet/' . $filename : null;
        $outlet->jam_buka = $request->jam_buka;
        $outlet->jam_tutup = $request->jam_tutup;
        $outlet->deskripsi = $request->deskripsi;

        $outlet->save();

        return redirect()->route('home')->with('success', 'Outlet berhasil diajukan');
    }



}
