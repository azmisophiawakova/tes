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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id('id_favorit');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_produk')->constrained('products', 'id_produk')->onDelete('cascade');
            $table->dateTime('tanggal_disimpan')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
