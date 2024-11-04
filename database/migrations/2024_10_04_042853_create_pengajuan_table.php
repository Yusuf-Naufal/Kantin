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
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            // Pengaju
            $table->unsignedBigInteger('id_user')->nullable();
            // Outlet
            $table->string('nama_outlet')->nullable();
            $table->string('alamat');
            $table->string('no_telp');
            $table->string('email')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('tiktok')->nullable();
            // Detail Outlet
            $table->string('foto')->nullable();
            $table->string('deskripsi')->nullable();
            $table->string('pin')->nullable();
            $table->string('jam_buka')->nullable();
            $table->string('jam_tutup')->nullable();
            $table->string('status')->nullable()->default('Pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};
