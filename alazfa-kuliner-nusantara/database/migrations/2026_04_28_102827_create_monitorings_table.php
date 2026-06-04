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
        Schema::create('monitorings', function (Blueprint $table) {
            $table->id('id_log');
            $table->foreignId('id_user')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('aktivitas', 255);
            $table->enum('kategori_aktivitas', ['login', 'transaksi', 'pembayaran', 'verifikasi', 'sistem']);
            $table->integer('referensi_id')->nullable();
            $table->enum('status', ['berhasil', 'gagal']);
            $table->text('keterangan')->nullable();
            $table->dateTime('waktu_aktivitas')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitorings');
    }
};
