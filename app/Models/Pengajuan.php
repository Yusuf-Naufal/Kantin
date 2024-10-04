<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';
    protected $fillable = [
        'nama_outlet',
        'alamat',
        'no_telp',
        'email',
        'instagram',
        'facebook',
        'tiktok',
        'foto',
        'nama_outlet',
        'deskripsi',
        'jam_buka',
        'jam_tutup',
        'status',
    ];

    // Relasi dengan User
    public function User(){
        return $this->belongsTo(User::class, 'id_user');
    }
}
