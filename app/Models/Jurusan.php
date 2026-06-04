<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';
    protected $primaryKey = 'id_jurusan';
    public $timestamps = false; // Karena tidak ada kolom created_at/updated_at bawaan Laravel

    protected $fillable = [
        'nama_jurusan',
        'deskripsi_singkat',
        'kategori_relevan',
        'prospek_karir',
        'gambar_url',
    ];

    // Relasi: Satu jurusan memiliki banyak data roadmap/mata kuliah
    public function roadmap(): HasMany
    {
        return $this->hasMany(Roadmap::class, 'id_jurusan', 'id_jurusan');
    }

    // Relasi: Satu jurusan bisa muncul di banyak hasil tes
    public function hasilTes(): HasMany
    {
        return $this->hasMany(HasilTes::class, 'id_jurusan', 'id_jurusan');
    }

    // Relasi Many-to-Many: Jurusan tersedia di banyak Kampus (via tabel relasi_kampus_jurusan)
    public function kampus(): BelongsToMany
    {
        return $this->belongsToMany(Kampus::class, 'relasi_kampus_jurusan', 'id_jurusan', 'id_kampus')
                    ->withPivot('id_relasi');
    }
}