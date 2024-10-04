<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'sku',
        'nama_produk',
        'id_kategori',
        'id_unit',
        'sku',
        'id_outlet',
        'harga_beli',
        'harga_jual',
        'stok',
        'stok_minimum',
        'foto',
        'diskon',
        'deskripsi',
    ];

    // Relasi dengan Kategori
    public function Kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
    // Relasi dengan Unit
    public function Unit()
    {
        return $this->belongsTo(Unit::class, 'id_unit');
    }
    // Relasi dengan Outlet
    public function Outlet()
    {
        return $this->belongsTo(Outlet::class, 'id_outlet');
    }
    // Relasi dengan DetailTransaksi
    public function DetailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_produk');
    }
}
