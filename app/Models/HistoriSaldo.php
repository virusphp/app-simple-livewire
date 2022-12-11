<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriSaldo extends Model
{
    use HasFactory;

    protected $table = "histori_saldos";
    public $timestamps = true;

    protected $fillable = [
        'user_id', 'saldo_awal', 'nominal', 'saldo_akhir', 'jenis_transaksi', 'kode_transaksi',
    ];

    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    public function topup()
    {
        return $this->belongsTo(TopupSaldo::class, 'kode_transaksi', 'kode_transaksi');
    }

    public function packet()
    {
        return $this->belongsTo(PacketTransaction::class, 'kode_transaksi');
    }

    public function saldo()
    {
        return $this->belongsTo(Saldo::class, 'histori_saldo_id', 'id');
    }

    public function updatesaldo()
    {
        return $this->hasOne(Saldo::class, 'histori_saldo_id', 'id');
    }
}
