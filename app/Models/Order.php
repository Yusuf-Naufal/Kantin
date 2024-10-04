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
        'pembayaran',
        'total_belanja',
        'ongkir',
        'total_barang',
        'total_keuntungan',
        'status',
        'catatan',
    ];

    // Relasi dengan Outlet
    public function Outlet()
    {
        return $this->belongsTo(Outlet::class, foreignKey: 'id_outlet');
    }

    // Relasi dengan Detail Order
    public function DetailOrder()
    {
        return $this->hasMany(DetailOrder::class, foreignKey: 'id_order');
    }
}
