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
        Schema::create('relasi_kampus_jurusan', function (Blueprint $table) {
            $table->integer('id_relasi')->autoIncrement();
            $table->integer('id_kampus');
            $table->integer('id_jurusan');

            // Foreign Keys
            $table->foreign('id_kampus')->references('id_kampus')->on('kampus')->onDelete('cascade');
            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relasi_kampus_jurusan');
    }
};
