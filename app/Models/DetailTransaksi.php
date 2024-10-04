<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';

    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'jumlah_barang',
        'subtotal',
        'keuntungan',  
    ];

    // Relasi dengan Transaksi
    public function Transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    // Relasi dengan Produk
    public function Produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
