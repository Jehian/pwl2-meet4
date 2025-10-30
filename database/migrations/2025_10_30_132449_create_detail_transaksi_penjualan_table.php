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
        Schema::create('detail_transaksi_penjualan', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_transaksi_penjualan');
        $table->unsignedBigInteger('id_product');
        $table->integer('jumlah_pembelian');
        $table->timestamps();

        $table->foreign('id_transaksi_penjualan')->references('id')->on('transactions')->onDelete('cascade');
        $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi_penjualan');
    }
};
