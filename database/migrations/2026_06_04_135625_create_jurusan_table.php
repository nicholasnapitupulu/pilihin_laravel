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
        Schema::create('jurusan', function (Blueprint $table) {
            $table->integer('id_jurusan')->autoIncrement();
            $table->string('nama_jurusan', 100);
            $table->text('deskripsi_singkat');
            $table->string('kategori_relevan', 50);
            $table->text('prospek_karir')->nullable();
            $table->string('gambar_url', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusan');
    }
};
