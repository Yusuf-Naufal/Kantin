<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'uid' => 'AA000',
            'username' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => Carbon::now(),
            'google_id' => null,
            'password' => bcrypt('AdminKantin00'), // Pastikan untuk meng-hash password
            'name' => 'Admin User',
            'tanggal_lahir' => '2004/05/19',
            'jenis_kelamin' => 'Laki-laki',
            'no_telp' => null,
            'alamat' => 'Jl. Indonesia 01',
            'foto' => null,
            'role' => 'Admin',
            'id_outlet' => null,
            'catatan' => null,
            'status' => 'Aktif',
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
