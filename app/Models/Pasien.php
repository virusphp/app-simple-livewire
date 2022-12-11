<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pasien','alamat_pasien','tanggal_lahir','tempat_lahir','aktif'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
