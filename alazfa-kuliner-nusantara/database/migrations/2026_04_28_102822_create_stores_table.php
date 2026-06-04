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
        Schema::create('stores', function (Blueprint $table) {
            $table->id('id_toko');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('nama_toko', 100);
            $table->text('deskripsi_toko')->nullable();
            $table->text('alamat_toko')->nullable();
            $table->string('foto_toko', 255)->nullable();
            $table->enum('status_verifikasi', ['menunggu konfirmasi', 'disetujui', 'ditolak'])->default('menunggu konfirmasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
