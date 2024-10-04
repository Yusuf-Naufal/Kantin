<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $fillable = [
        'resi',
        'status',
        'catatan',
        'tanggal_transaksi',
        'nama_pembeli',
        'total_barang',
        'total_belanja',
        'total_keuntungan',
        'id_outlet',
    ];

    // Relasi dengan Outlet
    public function Outlet()
    {
        return $this->belongsTo(Outlet::class, 'id_outlet');
    }

    // Relasi dengan DetailTransaksi
    public function DetailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}
