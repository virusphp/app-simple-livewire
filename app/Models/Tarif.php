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

    public function scopePencarian($query, $search)
    {
        return $query->when($search, function($q, $search) {
            $q->where('nama_negara', 'like', "%{$search}%");
        });
    }

    // public function scopeFilter($query, $jenis)
    // {
    //     return $query->when($jenis, function($q, $jenis) {
    //         $q->where('nama_negara', 'like', "%{$jenis}%");
    //     });
    // }


    public function jenis()
    {
        return $this->hasMany(JenisPaket::class, 'kode_jenis','kode_jenis');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
