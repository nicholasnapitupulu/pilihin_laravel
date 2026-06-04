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
        Schema::create('kampus', function (Blueprint $table) {
            $table->integer('id_kampus')->autoIncrement();
            $table->string('nama_kampus', 150);
            $table->string('lokasi', 255)->nullable();
            $table->string('akreditasi', 10)->nullable();
            $table->string('estimasi_biaya', 100)->nullable();
            $table->string('logo_kampus', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kampus');
    }
};
