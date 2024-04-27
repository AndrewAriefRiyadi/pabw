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
        Schema::create('pv_keranjang_produks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('id_keranjang');
            $table->unsignedBigInteger('id_produk');
            $table->integer('jumlah');
            $table->unsignedBigInteger('id_status');
            $table->foreign('id_produk')
                ->references('id')->on('produks')
                ->onDelete('cascade');
            $table->foreign('id_status')
                ->references('id')->on('vl_status_barang')
                ->onDelete('cascade');
            $table->foreign('id_keranjang')
                ->references('id')->on('keranjangs')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pv_keranjang_produk_tables');
    }
};
