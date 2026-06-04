<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Roadmap extends Model
{
    use HasFactory;

    protected $table = 'roadmap';
    protected $primaryKey = 'id_roadmap';
    public $timestamps = false;

    protected $fillable = [
        'id_jurusan',
        'semester',
        'nama_matkul',
        'kategori_matkul',
        'skill_didapat',
    ];

    // Relasi: Mata kuliah/roadmap ini milik jurusan tertentu
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }
}