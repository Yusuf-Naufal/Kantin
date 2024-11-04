<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';

    protected $fillable =[
        'resi',
        'id_outlet',
        'nama_pemesan',
        'no_telp',
        'tanggal_order',
        'alamat_tujuan',
        'jam_ambil',
        'metode',
        'pembayaran',
        'total_belanja',
        'total_barang',
        'total_keuntungan',
        'status',
        'catatan',
        'latitude',
        'longitude',
    ];

    // Relasi dengan Outlet
    public function Outlet()
    {
        return $this->belongsTo(Outlet::class,  'id_outlet');
    }

    // Relasi dengan Detail Order
    public function DetailOrder()
    {
        return $this->hasMany(DetailOrder::class,  'id_order');
    }

    public function Produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

}
