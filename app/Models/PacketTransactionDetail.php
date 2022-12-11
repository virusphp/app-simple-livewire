<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacketTransactionDetail extends Model
{
    public $timestamps = true;

    protected $table = "packet_transaction_details";
    protected $fillable = [
        'kode_transaksi_paket',
        'berat', 'harga', 'harga_total'
    ];

    public function header()
    {
        return $this->belongsTo(PacketTransaction::class, 'kode_transaksi_paket');
    }
}
