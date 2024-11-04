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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_transaksi')->nullable();
            $table->unsignedBigInteger('id_produk')->nullable();
            $table->string('status')->nullable();
            $table->bigInteger('diskon')->nullable();
            $table->bigInteger('jumlah_barang');
            $table->double('subtotal')->nullable();
            $table->double('keuntungan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
