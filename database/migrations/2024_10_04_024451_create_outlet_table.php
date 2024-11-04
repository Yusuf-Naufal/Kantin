<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('outlet', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->nullable();
            // Outlet
            $table->string('nama_outlet')->nullable();
            $table->string('alamat');
            $table->string('no_telp');
            $table->string('pemilik');
            $table->string('email')->unique()->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('tiktok')->nullable();
            // Detail Outlet
            $table->string('foto')->nullable();
            $table->string('deskripsi')->nullable();
            $table->time('jam_buka')->nullable();
            $table->time('jam_tutup')->nullable();
            $table->string('status')->nullable();
            $table->string('pin')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outlet');
    }
};
