<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('inventories', function (Blueprint $table) {
        $table->id();
        $table->string('kode_barang')->unique();
        $table->string('nama_barang');
        $table->string('kategori')->nullable();
        $table->integer('jumlah')->default(1);
        $table->string('satuan')->nullable();
        $table->string('kondisi')->nullable();
        $table->string('lokasi')->nullable();
        $table->date('tanggal_masuk')->nullable();
        $table->text('keterangan')->nullable();
        $table->string('added_by')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
