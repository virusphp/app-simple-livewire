<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;
    protected $table = "trackings";

    public $timestamps = true;

    protected $fillable = [
        'id', 'tanggal', 'kode_transaksi_paket', 'status_tracking', 'lokasi_pemeriksaan', 'nama_pic'
    ];
}
