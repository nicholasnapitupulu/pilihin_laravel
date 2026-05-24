<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kampus extends Model
{
    // Beritahu Laravel nama tabel yang benar
    protected $table = 'kampus';

    // Beritahu Laravel Primary Key-nya custom
    protected $primaryKey = 'id_kampus';

    // Disable timestamps karena tabelmu hanya punya 'created_at' tanpa 'updated_at'
    public $timestamps = false; 

    // Kolom apa saja yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'nama_kampus', 
        'lokasi', 
        'akreditasi', 
        'estimasi_biaya', 
        'logo_kampus',
        'created_at'
    ];

    // Relasi Many-to-Many dengan Jurusan
    public function jurusan()
    {
        return $this->belongsToMany(
            Jurusan::class, 
            'relasi_kampus_jurusan', // Nama tabel pivot
            'id_kampus',             // Foreign key untuk kampus di tabel pivot
            'id_jurusan'             // Foreign key untuk jurusan di tabel pivot
        );
    }
}