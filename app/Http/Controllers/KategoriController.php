<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KategoriController extends Controller
{
    // KONTROL TAMPILAN 

    // ADMIN
    // 1.  TAMPILAN KATEGORI

    public function AdminKategori(Request $request)
    {
        // Mengambil parameter per_page dari request, jika tidak ada, default ke 10
        $perPage = $request->get('per_page', 10);

        // Mengambil parameter pencarian
        $search = $request->get('search');
        $idOutlet = $request->get('id_outlet');

        // Melakukan query pada model Unit
        $query = Kategori::with('Outlet');

        // Filter berdasarkan outlet jika id_outlet diberikan
        if ($idOutlet) {
            $query->where('id_outlet', $idOutlet);
        }

        // Melakukan paginasi pada model Unit
        $kategori = $query->paginate($perPage);

        // Mengambil semua data Outlet tanpa paginasi
        $outlet = Outlet::orderBy('nama_outlet', 'asc')->get();

        return view('admin.kategori-index', [
            'title' => 'All Kategori',
            'kategoris' => $kategori,
            'outlets' => $outlet,
        ]);
    }

    // PEMILIK
    // 1. TAMPILAN KATEGORI
    public function MasterKategori(Request $request){
        $user = Auth::user();

        // Mengambil parameter per_page dari request, jika tidak ada, default ke 10
        $perPage = $request->get('per_page', 10);
        
        
        $kategori = Kategori::where('id_outlet',$user->id_outlet)
        ->paginate($perPage);


        return view('Pemilik.kategori', [
            'title' => 'Kategori Produk',
            'kategoris' => $kategori,
            'user' => $user,
        ]);
    }

    // QUERY KATEGORI KONTROL

    // ADMIN
    // 1.Tambah kategori

    public function AdminStore(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string',
            
        ]);

        Kategori::create([
            'nama_kategori' => ucwords(strtolower($request->nama_kategori)),
            'id_outlet' => $request->id_outlet,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    // 2. Tambah Kategori dari produk 
    public function AdminProdukAddKategori(Request $request, $uid)
    {
        $outlet = Outlet::where('uid', $uid)->firstOrFail();

        // Validasi input
        $request->validate([
            'nama_kategori' => 'required|string',
        ]);

        // Cek apakah kategori dengan nama yang sama sudah ada untuk outlet tersebut
        $kategoriExists = Kategori::where('nama_kategori', ucwords(strtolower($request->nama_kategori)))
            ->where('id_outlet', $outlet->id)
            ->exists();

        if ($kategoriExists) {
            // Jika sudah ada, kembali dengan pesan error
            return redirect()->back()->with('error', 'Kategori dengan nama tersebut sudah ada untuk outlet ini.');
        }

        // Jika belum ada, buat kategori baru
        Kategori::create([
            'nama_kategori' => ucwords(strtolower($request->nama_kategori)),
            'id_outlet' => $outlet->id,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambah.');
    }

    // PEMILIK
    // 1. Tambah kategori 
    public function MasterStore(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nama_kategori' => 'required|string',

        ]);

        Kategori::create([
            'nama_kategori' => ucwords(strtolower($request->nama_kategori)),
            'id_outlet' => $user->id_outlet,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }


    // ADMIN DAN PEMILIK 
    // 1. Update kategori
    public function UpdateKategori(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_kategori' => 'required|string',
        ]);

        // Temukan kategori berdasarkan ID
        $kategori = Kategori::findOrFail($id);

        // Update kategori
        $kategori->update([
            'nama_kategori' => ucwords(strtolower($request->nama_kategori)),
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diubah.');
    }

    // 2. Delete Kategori
    public function DestroyKategori($id)
    {
        $kategori = Kategori::findOrFail($id);

        $produk = Produk::where('id_kategori', $id)->get();


        foreach ($produk as $item) {
            // Cek jika produk memiliki foto
            if ($item->foto && Storage::exists('assets/' . $item->foto)) {
                // Menghapus file gambar dari storage
                Storage::delete('assets/' . $item->foto);
            }

            // Hapus produk dari database
            $item->delete();
        }
        
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }

}
