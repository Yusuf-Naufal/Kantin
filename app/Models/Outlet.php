<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    protected $table = 'outlet';

    protected $fillable = [
        'nama_outlet',
        'alamat',
        'no_telp',
        'id_user',
        'email',
        'instagram',
        'nama_outlet',
        'facebook',
        'tiktok',
        'foto',
        'deskripsi',
        'jam_buka',
        'jam_tutup',
        'status',
    ];

    // Relasi dengan User
    public function User()
    {
        return $this->hasMany(User::class, 'id_user');
    }

    // Relasi dengan Transaksi
    public function Transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_outlet');
    }

    // Relasi dengan Produk
    public function Produk()
    {
        return $this->hasMany(Produk::class, 'id_produk');
    }






}
