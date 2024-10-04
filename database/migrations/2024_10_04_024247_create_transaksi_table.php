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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            // Transaksi
            $table->string('resi')->nullable();
            $table->string('status')->nullable();
            $table->string('catatan')->nullable();
            // Detail
            $table->date('tanggal_transaksi')->nullable();
            $table->string('nama_pembeli')->nullable();
            $table->bigInteger('total_barang')->nullable();
            $table->double('total_belanja')->nullable();
            $table->double('total_keuntungan')->nullable();
            $table->unsignedBigInteger('id_outlet')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
