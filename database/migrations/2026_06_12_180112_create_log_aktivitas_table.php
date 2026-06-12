<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->string('pesan'); // Menyimpan pesan tindakan, misal: "Admin menambahkan Universitas Airlangga"
            $table->unsignedBigInteger('id_user')->nullable(); // Siapa admin yang melakukan aksi
            $table->timestamps(); // Menghasilkan created_at dan updated_at otomatis
        });
    }

    public function down()
    {
        Schema::dropIfExists('log_aktivitas');
    }
};