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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_toko')->constrained('stores', 'id_toko')->onDelete('cascade');
            $table->foreignId('id_kurir')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('tanggal_pesanan')->useCurrent();
            $table->decimal('total_harga', 10, 2);
            $table->text('alamat_pengiriman');
            $table->enum('status_pesanan', ['konfirmasi pesanan', 'pesanan diproses', 'pesanan dikirim', 'pesanan selesai', 'pesanan dibatalkan'])->default('konfirmasi pesanan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
