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
        Schema::create('products', function (Blueprint $table) {
            $table->id('id_produk');
            $table->foreignId('id_toko')->constrained('stores', 'id_toko')->onDelete('cascade');
            $table->foreignId('id_kategori')->constrained('categories', 'id_kategori')->onDelete('cascade');
            $table->string('nama_produk', 100);
            $table->text('deskripsi_produk')->nullable();
            $table->text('resep')->nullable();
            $table->decimal('harga', 10, 2);
            $table->integer('stok')->default(0);
            $table->string('foto_produk', 255)->nullable();
            $table->enum('status_produk', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
