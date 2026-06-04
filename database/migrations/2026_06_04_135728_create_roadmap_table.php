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
        Schema::create('roadmap', function (Blueprint $table) {
            $table->integer('id_roadmap')->autoIncrement();
            $table->integer('id_jurusan');
            $table->integer('semester');
            $table->string('nama_matkul', 100);
            $table->string('kategori_matkul')->default(''); // atau mengunakan ->enum('kategori_matkul', ['Fondasi', 'Profesional']) jika diwajibkan enum
            $table->string('skill_didapat', 255)->nullable();

            // Foreign Key
            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusan')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roadmap');
    }
};
