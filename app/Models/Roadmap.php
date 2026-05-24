<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roadmap extends Model
{
    protected $table = 'roadmap';
    protected $primaryKey = 'id_roadmap';
    public $timestamps = false; // Karena tabel roadmap tidak punya created_at

    // Relasi: Setiap Roadmap ini milik 1 Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }
}