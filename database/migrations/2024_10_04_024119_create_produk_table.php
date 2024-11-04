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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            // Produk
            $table->string('sku')->nullable();
            $table->string('nama_produk')->nullable();
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->unsignedBigInteger('id_unit')->nullable();
            $table->unsignedBigInteger('id_outlet')->nullable();
            // Detail Produk
            $table->double('harga_modal')->nullable();
            $table->double('harga_jual')->nullable();
            $table->double('harga_diskon')->nullable();
            $table->string('stok')->nullable();
            $table->string('stok_minimum')->nullable();
            $table->string('foto')->nullable();
            $table->bigInteger('diskon')->nullable();
            $table->string('deskripsi')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
