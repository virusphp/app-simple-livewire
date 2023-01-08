<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarifLokal extends Model
{
    use HasFactory;

    protected $fillable = [
       'district_id',
       'regency_id',
       'nama_gudang',
       'tarif_lokal',
       'user_id'
    ];

    public function scopePencarian($query, $search)
    {
        return $query->when($search, function($q, $search) {
            $q->where('nama_gudang', 'like', "%{$search}%")
            ->orWhereHas('kecamatan', function($query) use($search) {
                $query->where('name', 'like', "%{$search}%");
            });
        });
    }

    public function scopeLatest($query) 
    {
        return $query->orderBy('created_at', 'DESC');
    }

    public function kota()
    {
        return $this->belongsTo(Regency::class, 'regency_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
