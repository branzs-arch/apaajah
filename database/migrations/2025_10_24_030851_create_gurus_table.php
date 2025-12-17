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
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique()->nullable();        // Nomor Induk Pegawai
            $table->string('nama_lengkap');                     // Nama lengkap guru
            $table->string('tempat_lahir')->nullable();         // Tempat lahir
            $table->date('tanggal_lahir')->nullable();          // Tanggal lahir
            $table->string('alamat')->nullable();               // Alamat tempat tinggal
            $table->string('mata_pelajaran')->nullable();       // Mata pelajaran yang diampu
            $table->string('no_hp')->nullable();                // Nomor HP
            $table->string('added_by')->nullable();             // Admin / user yang menambah data
            $table->boolean('is_active')->default(true);        // Status aktif atau tidak
            $table->timestamps();                               // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
