<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hasil_Tes extends Model
{
    use HasFactory;

    protected $table = 'hasil_tes';
    protected $primaryKey = 'id_hasil';
    
    // Menggunakan kolom tanggal_tes bawaan SQL untuk created_at, nonaktifkan updated_at
    const CREATED_AT = 'tanggal_tes';
    const UPDATED_AT = null;

    protected $fillable = [
        'id_user',
        'id_jurusan',
        'skor_kecocokan',
        'tanggal_tes',
    ];

    // Relasi: Hasil tes ini milik user tertentu
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi: Hasil tes ini merujuk ke jurusan tertentu
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }
}