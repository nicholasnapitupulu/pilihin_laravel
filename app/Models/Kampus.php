<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kampus extends Model
{
    use HasFactory;

    protected $table = 'kampus';
    protected $primaryKey = 'id_kampus';
    
    // Hanya ada created_at di tabel, matikan updated_at agar Laravel tidak error saat save
    const UPDATED_AT = null; 

    protected $fillable = [
        'nama_kampus',
        'lokasi',
        'akreditasi',
        'estimasi_biaya',
        'logo_kampus',
    ];

    // Relasi Many-to-Many: Kampus memiliki banyak Jurusan (via tabel relasi_kampus_jurusan)
    public function jurusan(): BelongsToMany
    {
        return $this->belongsToMany(Jurusan::class, 'relasi_kampus_jurusan', 'id_kampus', 'id_jurusan')
                    ->withPivot('id_relasi');
    }
}