<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Questions extends Model
{
    use HasFactory;

    protected $table = 'questions';
    protected $primaryKey = 'id_soal';
    public $timestamps = false;

    protected $fillable = [
        'teks_pertanyaan',
        'kategori_minat',
    ];
}