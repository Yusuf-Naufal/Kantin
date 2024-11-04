<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'unit';
    protected $fillable = [
        'nama_unit',
        'id_outlet',
    ];

    // Relasi dengan Produk
    public function Produk()
    {
        return $this->hasMany(Produk::class, 'id_unit');
    }
    
    public function Outlet()
    {
        return $this->belongsTo(Outlet::class, 'id_outlet');
    }
}

