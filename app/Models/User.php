<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Login
        'email',
        'password',
        'username',
        'uid',
        'google_id',
        // Data Pribadi
        'name',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_telp',
        'alamat',
        'foto',
        'role',
        'id_outlet',
        'catatan',
    ];

    // Relasi dengan Outlet
    public function Outlet()
    {
        return $this->belongsTo(Outlet::class,'id_outlet');
    }
    
    // Relasi dengan Pengajuan
    public function Pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'id_user');
    }



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
