<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    use HasFactory;

    protected $table = 'detail_order';

    protected $fillable = [
        'id_order',
        'id_produk',
        'jumlah_barang',
        'subtotal',
        'keuntungan',
    ];

    // Relasi dengan Order
    public function Order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }

    // Relasi dengan Produk
    public function Produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

}
