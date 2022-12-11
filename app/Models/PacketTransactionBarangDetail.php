<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacketTransactionBarangDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        "kode_transaksi_paket", "nama_barang","jumlah_barang","harga_barang"
    ];

    public function header()
    {
        return $this->belongsTo(PacketTransaction::class, 'kode_transaksi_paket');
    }
}
