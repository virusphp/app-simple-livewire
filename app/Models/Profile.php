<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $primaryKey = "kode_agen";

    protected $keyType = "string";

    public $incrementing = false;

    protected $fillable = [
        'kode_agen',
        'nama_agen',
        'alamat_agen',
        'no_telpon',
        'province_id',
        'regency_id',
        'district_id',
        'village_id'
    ];

    public function user()
    {
        return $this->hasOne(User::class, "kode_agen", "kode_agen");
    }

    public function scopePencarian($query, $search)
    {
        return $query->when($search, function($q, $search) {
            $q->where('nama_agen', 'like', "%{$search}%");
        });
    }

    public function scopeActived($query, $isActive)
    {
        return $query->whereHas('user', function($query) use ($isActive) {
            $query->when($isActive, function($query) {
                $query->where('users.is_active', '=', 1);
            });
        });
    }


}
