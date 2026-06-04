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
        Schema::create('verifications', function (Blueprint $table) {
            $table->id('id_verifikasi');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_pesanan')->nullable()->constrained('orders', 'id_pesanan')->onDelete('cascade');
            $table->foreignId('id_pembayaran')->nullable()->constrained('payments', 'id_pembayaran')->onDelete('cascade');
            $table->enum('metode_verifikasi', ['PIN'])->default('PIN');
            $table->string('kode_verifikasi', 255);
            $table->enum('status_verifikasi', ['pending', 'berhasil', 'gagal'])->default('pending');
            $table->integer('percobaan')->default(0);
            $table->dateTime('waktu_kirim')->useCurrent();
            $table->dateTime('waktu_verifikasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifications');
    }
};
