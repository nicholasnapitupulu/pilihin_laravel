<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan';
    protected $primaryKey = 'id_jurusan';
    public $timestamps = false; // Tabel jurusan tidak punya created_at & updated_at

    protected $fillable = [
        'nama_jurusan', 
        'deskripsi_singkat', 
        'kategori_relevan', 
        'prospek_karir', 
        'gambar_url'
    ];

    // Relasi Many-to-Many dengan Kampus
    public function kampus()
    {
        return $this->belongsToMany(
            Kampus::class, 
            'relasi_kampus_jurusan', 
            'id_jurusan', 
            'id_kampus'
        );
    }

    // Relasi One-to-Many dengan Roadmap
    public function roadmap()
    {
        // Ambil data roadmap dan langsung urutkan berdasarkan semester (1, 2, 3...)
        return $this->hasMany(Roadmap::class, 'id_jurusan', 'id_jurusan')->orderBy('semester', 'asc');
    }
}