<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $fillable = [
        'nama_kategori',
        'id_outlet',
    ];

    // Relasi dengan Produk
    public function Produk()
    {
        return $this->hasMany(Produk::class, 'id_kategori');
    }
}
