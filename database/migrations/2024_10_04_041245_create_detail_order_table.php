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
        Schema::create('detail_order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_order')->nullable();
            $table->unsignedBigInteger('id_produk')->nullable();
            $table->bigInteger('jumlah_barang')->nullable();
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
        Schema::dropIfExists('detail_order');
    }
};
