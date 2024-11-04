<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Outlet;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    // KONTROL TAMPILAN 

    // ADMIN
    // 1. Produk Outlet Tertentu

    public function AdminProdukOutlet(Request $request, $uid)
    {
        // Fetch the outlet based on uid, or fail if not found
        $outlet = Outlet::where('uid', $uid)->firstOrFail();

        // Get the number of items per page and the selected category
        $perPage = $request->get('per_page', 10);
        $idKategori = $request->get('id_kategori');

        // Menampilkan semua produk outletnya 
        $query = Produk::where('id_outlet', $outlet->id);

        // If an id_kategori is provided, filter the products
        if ($idKategori) {
            $query->where('id_kategori', $idKategori);
        }

        // Paginate the results
        $produk = $query->paginate($perPage);

        $kategori = Kategori::where('id_outlet', $outlet->id)->get();

        // Return the view with the products and outlet information
        return view('Admin.outlet.produk.produk-index', [
            'produks' => $produk,
            'title' => 'Produk Outlet',
            'outlet' => $outlet,
            'kategoris' => $kategori,
        ]);
    }

    // 2. Tambah Produk Outlet Tertentu
    public function AdminAddProdukOutlet($uid)
    {

        $outlet = Outlet::where('uid', $uid)->firstOrFail();
        $kategori = Kategori::where('id_outlet', $outlet->id)->get();
        $unit = Unit::where('id_outlet', $outlet->id)->get();


        return view('Admin.outlet.produk.add-produk', [
            'title' => 'Tambah Produk Outlet',
            'kategoris' => $kategori,
            'units' => $unit,
            'outlet' => $outlet,
        ]);

    }

    // 3. Edit Produk Outlet Tertentu
    public function AdminEditProdukOutlet($uid, $sku)
    {

        $outlet = Outlet::where('uid', $uid)->firstOrFail();
        $produk = Produk::where('sku', $sku)->firstOrFail();
        $kategori = Kategori::where('id_outlet', $outlet->id)->get();
        $unit = Unit::where('id_outlet', $outlet->id)->get();


        return view('Admin.outlet.produk.edit-produk', [
            'title' => 'Edit Produk Outlet',
            'kategoris' => $kategori,
            'units' => $unit,
            'outlet' => $outlet,
            'produk' => $produk,
        ]);

    }

    // 4. Semua Produk Outlet
    public function AdminProduk(Request $request)
    {
        // Get the number of items per page and the selected outlet
        $perPage = $request->get('per_page', 10);
        $idOutlet = $request->get('id_outlet');

        // Awalnya mendapatkan semua produk
        $query = Produk::query();

        // Jika ada id_outlet, filter produk berdasarkan outlet tersebut
        if (!empty($idOutlet)) {
            $query->where('id_outlet', $idOutlet);
        }

        // Paginate hasil query produk
        $produk = $query->paginate($perPage);

        // Ambil semua outlet
        $outlet = Outlet::all();

        // Return the view with the products and outlet information
        return view('Admin.produk.all-produk', [
            'title' => 'Semua Produk Outlet',
            'produks' => $produk,
            'outlets' => $outlet,
        ]);
    }

    // PEMILIK
    // 1. Tampil Produk
    public function MasterProdukOutlet(Request $request)
    {
        $user = Auth::user();

        // Get the number of items per page and the selected category
        $perPage = $request->get('per_page', 10);
        $idKategori = $request->get('id_kategori');

        // Menampilkan semua produk outletnya 
        $query = Produk::where('id_outlet', $user->id_outlet);

        // If an id_kategori is provided, filter the products
        if ($idKategori) {
            $query->where('id_kategori', $idKategori);
        }

        // Paginate the results
        $produk = $query->orderBy('created_at', 'desc')->paginate($perPage);

        $kategori = Kategori::where('id_outlet', $user->id_outlet)->get();

        // Return the view with the products and outlet information
        return view('Pemilik.produk.produk-index', [
            'produks' => $produk,
            'title' => 'Produk Outlet',
            'user' => $user,
            'kategoris' => $kategori,
        ]);
    }

    // 2. Tambah Produk
    public function MasterAddProduk()
    {
        $user = Auth::user();

        $kategori = Kategori::where('id_outlet', $user->id_outlet)->get();
        $unit = Unit::where('id_outlet', $user->id_outlet)->get();


        return view('Pemilik.produk.add-produk', [
            'title' => 'Tambah Produk',
            'kategoris' => $kategori,
            'units' => $unit,
            'user' => $user,
        ]);

    }

    // 3. Edit Produk
    public function MasterEditProdukOutlet($sku)
    {
        $user = Auth::user();

        $produk = Produk::where('sku', $sku)->firstOrFail();
        $kategori = Kategori::where('id_outlet', $user->id_outlet)->get();
        $unit = Unit::where('id_outlet', $user->id_outlet)->get();


        return view('Pemilik.produk.edit-produk', [
            'title' => 'Edit Produk Outlet',
            'kategoris' => $kategori,
            'units' => $unit,
            'user' => $user,
            'produk' => $produk,
        ]);

    }


    // QUERY PRODUK OUTLET MANAJAMEN

    // ADMIN
    // 1. Generate SKU produk

    protected function generateSKU($length = 13)
    {
        // Characters to use in SKU
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $sku = '';
        $maxLength = min($length, 13); // Ensure length does not exceed 13 characters

        for ($i = 0; $i < $maxLength; $i++) {
            $sku .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $sku;
    }

    // 1. Tambah Produk Outlet Tertentu 
    public function AdminStoreProduk(Request $request, $uid)
    {
        $validation = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'sku' => 'nullable|unique',
            'id_unit' => 'required|exists:unit,id',
            'id_outlet' => 'required|exists:outlet,id',
            'harga_jual' => 'required|numeric|min:0',
            'harga_modal' => 'required|numeric|min:0',
            'harga_diskon' => 'nullable|numeric',
            'diskon' => 'nullable|numeric|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors([
                'error' => 'Tambah produk error, pastikan semua data terisi dengan benar'
            ])->withInput();
        }

        // MENYIMPAN GAMBAR 
        if ($request->hasFile('foto')) {
            // Mengambil file gambar
            $foto = $request->file('foto');

            // Menghasilkan nama file unik berdasarkan timestamp
            $filename = time() . '.' . $foto->extension();

            // Menyimpan file ke dalam storage/app/public/assets folder
            $foto->storeAs('assets/produk', $filename);

        } else {
            $filename = null;
        }

        $sku = $request->sku ? $request->sku : $this->generateSKU();

        $produk = new Produk();
        $produk->nama_produk = $request->nama_produk;
        $produk->sku = $sku;
        $produk->id_kategori = $request->id_kategori;
        $produk->id_unit = $request->id_unit;
        $produk->id_outlet = $request->id_outlet;
        $produk->stok = $request->stok;
        $produk->stok_minimum = $request->stok_minimum;
        $produk->harga_jual = $request->harga_jual;
        $produk->harga_modal = $request->harga_modal;
        $produk->harga_diskon = $request->harga_diskon;
        $produk->diskon = $request->diskon;
        $produk->deskripsi = $request->deskripsi;
        $produk->status = $request->status;

        // MENAMBAH  FOTO
        $produk->foto = $filename ? 'produk/' . $filename : null;

        $produk->save();

        return redirect()->route('admin-all-produk-outlet', $uid)->with('success', 'Produk berhasil ditambah!!');
    }

    // 2. Update Produk Outlet Tertentu
    public function AdminUpdateProdukOutlet(Request $request, $uid, $id)
    {
        $produk = Produk::findOrFail($id);

        // Validasi permintaan
        $validation = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'sku' => 'nullable|unique:produk,sku,' . $produk->id,
            'id_unit' => 'required|exists:unit,id',
            'id_outlet' => 'required|exists:outlet,id',
            'harga_jual' => 'required|numeric|min:0',
            'harga_modal' => 'required|numeric|min:0',
            'harga_diskon' => 'nullable|numeric',
            'diskon' => 'nullable|numeric|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors([
                'error' => 'Update error, pastikan semua terisi dengan benar.'
            ])->withInput();
        }

        // Jika ada foto baru yang diunggah
        if ($request->hasFile('foto')) {
            // Mengambil file gambar
            $foto = $request->file('foto');

            // Menghasilkan nama file unik berdasarkan timestamp
            $filename = time() . '.' . $foto->extension();

            if ($produk->foto) {
                // Hapus file dari storage dengan path yang sesuai
                Storage::disk('public')->delete('assets/produk/' . basename($produk->foto));
            }

            $foto->storeAs('assets/produk', $filename, 'public');

            // Simpan path baru ke database
            $produk->foto = 'produk/' . $filename;
        } else {
            // Jika tidak ada gambar baru yang diunggah, jangan mengubah path foto
            $filename = $produk->foto;
        }


        // Perbarui atribut produk
        $produk->nama_produk = $request->nama_produk;
        $produk->sku = $request->sku;
        $produk->id_kategori = $request->id_kategori;
        $produk->id_unit = $request->id_unit;
        $produk->id_outlet = $request->id_outlet;
        $produk->stok = $request->stok;
        $produk->stok_minimum = $request->stok_minimum;
        $produk->harga_jual = $request->harga_jual;
        $produk->harga_modal = $request->harga_modal;
        $produk->harga_diskon = $request->harga_diskon;
        $produk->diskon = $request->diskon;
        $produk->deskripsi = $request->deskripsi;
        $produk->status = $request->status;
        $produk->save();

        return redirect()->route('admin-all-produk-outlet', $uid)->with('success', 'Produk berhasil diupdate!');
        // return $request;
    }

    // 3. Hapus Produk Outlet Tertentu
    public function DestroyProdukOutlet($uid, $sku)
    {
        // Mencari produk berdasarkan UID
        $produk = Produk::where('sku', $sku)->firstOrFail();

        // Hapus gambar produk jika ada
        if ($produk->foto && Storage::exists('assets/' . $produk->foto)) {
            // Menghapus file gambar dari storage
            Storage::delete('assets/' . $produk->foto);
        }

        // Hapus produk dari database
        $produk->delete();

        // Redirect atau berikan respon setelah berhasil menghapus
        return redirect()->back()->with('success', 'Produk dan foto berhasil dihapus');
    }

    // 4. Update Status Outlet Tertentu
    public function AdminStatusProdukOutletUpdate($uid, $sku)
    {

        $produk = Produk::where('sku', $sku)->firstOrFail();
        if ($produk) {
            if ($produk->status == 'Habis') {
                $produk->status = 'Aktif';
            } else {
                $produk->status = 'Habis';
            }
            $produk->save();
            return redirect()->back()->with('success', 'Status produk berhasil diubah.');
        }
        return redirect()->back()->with('error', 'Outlet Anomali');
    }


    // PEMILIK 
    // 1. Tambah Produk

    public function MasterStoreProduk(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'sku' => 'nullable|unique',
            'id_unit' => 'required|exists:unit,id',
            'id_outlet' => 'required|exists:outlet,id',
            'harga_jual' => 'required|numeric|min:0',
            'harga_modal' => 'required|numeric|min:0',
            'harga_diskon' => 'nullable|numeric',
            'diskon' => 'nullable|numeric|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors([
                'error' => 'Tambah produk error, pastikan semua data terisi dengan benar'
            ])->withInput();
        }

        // MENYIMPAN GAMBAR 
        if ($request->hasFile('foto')) {
            // Mengambil file gambar
            $foto = $request->file('foto');

            // Menghasilkan nama file unik berdasarkan timestamp
            $filename = time() . '.' . $foto->extension();

            // Menyimpan file ke dalam storage/app/public/assets folder
            $foto->storeAs('assets/produk', $filename);

        } else {
            $filename = null;
        }

        $sku = $request->sku ? $request->sku : $this->generateSKU();

        $produk = new Produk();
        $produk->nama_produk = $request->nama_produk;
        $produk->sku = $sku;
        $produk->id_kategori = $request->id_kategori;
        $produk->id_unit = $request->id_unit;
        $produk->id_outlet = $request->id_outlet;
        $produk->stok = $request->stok;
        $produk->stok_minimum = $request->stok_minimum;
        $produk->harga_jual = $request->harga_jual;
        $produk->harga_modal = $request->harga_modal;
        $produk->harga_diskon = $request->harga_diskon;
        $produk->diskon = $request->diskon;
        $produk->deskripsi = $request->deskripsi;
        $produk->status = $request->status;

        // MENAMBAH  FOTO
        $produk->foto = $filename ? 'produk/' . $filename : null;

        $produk->save();

        return redirect()->route('pemilik-produk')->with('success', 'Produk berhasil ditambah!!');
    }

    // 2. Update Produk
    public function MasterUpdateProdukOutlet(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        // Validasi permintaan
        $validation = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'sku' => 'nullable|unique:produk,sku,' . $produk->id,
            'id_unit' => 'required|exists:unit,id',
            'id_outlet' => 'required|exists:outlet,id',
            'harga_jual' => 'required|numeric|min:0',
            'harga_modal' => 'required|numeric|min:0',
            'harga_diskon' => 'nullable|numeric',
            'diskon' => 'nullable|numeric|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors([
                'error' => 'Update error, pastikan semua terisi dengan benar.'
            ])->withInput();
        }

        // Jika ada foto baru yang diunggah
        if ($request->hasFile('foto')) {
            // Mengambil file gambar
            $foto = $request->file('foto');

            // Menghasilkan nama file unik berdasarkan timestamp
            $filename = time() . '.' . $foto->extension();

            if ($produk->foto) {
                // Hapus file dari storage dengan path yang sesuai
                Storage::disk('public')->delete('assets/produk/' . basename($produk->foto));
            }

            $foto->storeAs('assets/produk', $filename, 'public');

            // Simpan path baru ke database
            $produk->foto = 'produk/' . $filename;
        } else {
            // Jika tidak ada gambar baru yang diunggah, jangan mengubah path foto
            $filename = $produk->foto;
        }


        // Perbarui atribut produk
        $produk->nama_produk = $request->nama_produk;
        $produk->sku = $request->sku;
        $produk->id_kategori = $request->id_kategori;
        $produk->id_unit = $request->id_unit;
        $produk->id_outlet = $request->id_outlet;
        $produk->stok = $request->stok;
        $produk->stok_minimum = $request->stok_minimum;
        $produk->harga_jual = $request->harga_jual;
        $produk->harga_modal = $request->harga_modal;
        $produk->harga_diskon = $request->harga_diskon;
        $produk->diskon = $request->diskon;
        $produk->deskripsi = $request->deskripsi;
        $produk->status = $request->status;
        $produk->save();

        return redirect()->route('pemilik-produk')->with('success', 'Produk berhasil diupdate!');
        // return $request;
    }


    // ADMIN DAN PEMILIK 
    // 1. Update Statys Semua Outlet
    public function StatusProdukUpdate($id)
    {
        $produk = Produk::where('id', $id)->firstOrFail();
        if ($produk) {
            if ($produk->status == 'Habis') {
                $produk->status = 'Aktif';
            } else {
                $produk->status = 'Habis';
                $produk->diskon = null;
                $produk->harga_diskon = null;
            }
            $produk->save();
            return redirect()->back()->with('success', 'Status produk berhasil diubah.');
        }
        return redirect()->back()->with('error', 'Produk Anomali');
    }

    // 2. Hapus Produk Outlet
    public function DestroyProduk($id)
    {
        // Mencari pengguna berdasarkan UID
        $produk = Produk::where('id', $id)->firstOrFail();

        // Hapus gambar pengguna jika ada
        if ($produk->foto && Storage::exists('assets/' . $produk->foto)) {
            // Menghapus file gambar dari storage
            Storage::delete('assets/' . $produk->foto);
        }

        // Hapus pengguna dari database
        $produk->delete();

        // Redirect atau berikan respon setelah berhasil menghapus
        return redirect()->back()->with('success', 'Produk dan foto berhasil dihapus');
    }

    // PEMILIK DAN KARYAWAN
    public function StokProdukOutlet()
    {
        $user = Auth::user();

        // Dapatkan outlets yang terkait dengan pengguna ini
        $outlets = $user->outlet;

        // Ambil produk yang terkait dengan outlet
        $produks = Produk::where('id_outlet', $outlets->id)->get();

        return view('Karyawan.stok-produk', [
            'title' => 'Stok Produk Outlet',
            'Outlet' => $outlets,
            'User' => $user,
            'Produk' => $produks,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        // Update the product status
        $produk->status = $request->status;
        $produk->diskon = null;
        $produk->harga_diskon = null;
        $produk->save();

        // Return a JSON response
        return response()->json(['success' => true]);
    }








}
