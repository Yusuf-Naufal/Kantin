<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Outlet;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UnitController extends Controller
{
    // KONTROL TAMPILAN 

    // ADMIN
    // 1.  TAMPILAN UNIT

    public function AdminUnit(Request $request)
    {
        // Mengambil parameter per_page dari request, jika tidak ada, default ke 10
        $perPage = $request->get('per_page', 10);

        // Mengambil parameter pencarian
        $search = $request->get('search');
        $idOutlet = $request->get('id_outlet');

        // Melakukan query pada model Unit
        $query = Unit::query();

        // Filter berdasarkan outlet jika id_outlet diberikan
        if ($idOutlet) {
            $query->where('id_outlet', $idOutlet);
        }

        // Melakukan paginasi pada model Unit
        $units = $query->paginate($perPage);

        // Mengambil semua data Outlet tanpa paginasi
        $outlet = Outlet::orderBy('nama_outlet', 'asc')->get();


        return view('admin.unit-index', [
            'title' => 'Unit',
            'units' => $units,
            'outlets' => $outlet,
        ]);
    }

    // PEMILIK
    // 1. TAMPILAN UNIT
    public function MasterUnit(Request $request)
    {
        $user = Auth::user();

        // Mengambil parameter per_page dari request, jika tidak ada, default ke 10
        $perPage = $request->get('per_page', 10);


        $unit = Unit::where('id_outlet', $user->id_outlet)
            ->paginate($perPage);


        return view('Pemilik.unit', [
            'title' => 'Unit Produk',
            'units' => $unit,
            'user' => $user,
        ]);
    }

    // QUERY UNIT KONTROL

    // ADMIN
    // 1.Tambah Unit

    public function AdminStore(Request $request)
    {
        $request->validate([
            'nama_unit' => 'required|string',

        ]);

        Unit::create([
            'nama_unit' => ucwords(strtolower($request->nama_unit)),
            'id_outlet' => $request->id_outlet,
        ]);

        return redirect()->back()->with('success', 'Unit berhasil ditambahkan.');
    }

    // 2. Tambah unit dari produk
    public function AdminProdukAddUnit(Request $request, $uid){
        $outlet = Outlet::where('uid', $uid)->firstOrFail();

        $request->validate([
            'nama_unit' => 'required|string',

        ]);

        // Cek apakah unit dengan nama yang sama sudah ada untuk outlet tersebut
        $unitExists = Unit::where('nama_unit', ucwords(strtolower($request->nama_unit)))
            ->where('id_outlet', $outlet->id)
            ->exists();

        if ($unitExists) {
            // Jika sudah ada, kembali dengan pesan error
            return redirect()->back()->with('error', 'Unit dengan nama tersebut sudah ada untuk outlet ini.');
        }

        Unit::create([
            'nama_unit' => ucwords(strtolower($request->nama_unit)),
            'id_outlet' => $outlet->id,
        ]);

        return redirect()->back()->with('success', 'Unit berhasil ditambah.');
    }

    // PEMILIK 
    // 1. Tambah Unit 
    public function MasterStore(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_unit' => 'required|string',

        ]);

        Unit::create([
            'nama_unit' => ucwords(strtolower($request->nama_unit)),
            'id_outlet' => $user->id_outlet,
        ]);

        return redirect()->back()->with('success', 'Unit berhasil ditambahkan.');
    }


    // ADMIN DAN PEMILIK 
    // 2. Update Unit
    public function UpdateUnit(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_unit' => 'required|string',
        ]);

        // Temukan Unit berdasarkan ID
        $Unit = Unit::findOrFail($id);

        // Update Unit
        $Unit->update([
            'nama_unit' => ucwords(strtolower($request->nama_unit)),
        ]);

        return redirect()->back()->with('success', 'Unit berhasil diubah.');
    }

    // 3. Delete Unit
    public function DestroyUnit($id)
    {
        $Unit = Unit::findOrFail($id);

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




        $Unit->delete();

        return redirect()->back()->with('success', 'Unit berhasil dihapus.');
    }
}
