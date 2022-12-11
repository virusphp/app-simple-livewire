<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    public $timestamps = true;

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

    public function provinsi()
    {
        return $this->hasOne(Province::class, 'id');
    }

    public function fee()
    {
        return $this->hasOne(FeeAgen::class);
    }

    public function kota()
    {
        return $this->belongsTo(Regency::class, 'regency_id');
    }

    public function scopeListAgen($query)
    {
        return $query->with('user')->role('agen');
    }

    // public function getAutoNumberOptions()
    // {
    //     return [
    //         'kode_agen' => [
    //             'format' => 'RJP'.date('Ymd').'?', // Format kode yang akan digunakan.
    //             'length' => 4 // Jumlah digit yang akan digunakan sebagai nomor urut
    //         ]
    //     ];
    // }
}
