<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupTransactionDetail extends Model
{
    public $timestamps = true;

    protected $fillable = [
        "kode_pickup", "kode_transaksi_paket"
    ];

    public function tracking()
    {
        return $this->hasOne(Tracking::class, 'kode_transaksi_paket', 'kode_transaksi_paket');
    }
}
