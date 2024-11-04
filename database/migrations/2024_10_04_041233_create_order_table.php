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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            // Order
            $table->unsignedBigInteger('id_outlet')->nullable();
            $table->string('resi')->nullable();
            $table->string('nama_pemesan')->nullable();
            $table->string('no_telp');
            $table->date('tanggal_order')->nullable();
            $table->string('alamat_tujuan')->nullable();
            $table->time('jam_ambil')->nullable();
            // Detail
            $table->string('pembayaran')->nullable();
            $table->string('metode')->nullable();
            $table->double('total_belanja')->nullable();
            $table->bigInteger('total_barang')->nullable();
            $table->double('total_keuntungan')->nullable();
            $table->string('status')->nullable();
            $table->text('catatan')->nullable();

            //
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
