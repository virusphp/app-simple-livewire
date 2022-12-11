<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_negara',
        'nama_negara',
        'kode_jenis',
        'berat',
        // 'tarif_agen',
        'tarif',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
