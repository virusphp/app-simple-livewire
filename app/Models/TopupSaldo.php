<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Virusphp\AutoNumber\AutoNumberTrait;

class TopupSaldo extends Model
{
    use HasFactory;

    use AutoNumberTrait;

    protected $table = "topup_saldos";
    protected $primaryKey = 'kode_transaksi';
    protected $keyType = 'string';
    // public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'kode_transaksi', 'nominal', 'bukti_transfer', 'bank_transfer', 'is_aproved', 'keterangan', 'user_id'
    ];

    public function history()
    {
        return $this->hasOne(HistoriSaldo::class, 'kode_transaksi');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAutoNumberOptions()
    {
        return [
            'kode_transaksi' => [
                'format' => 'TP' . date('Ymd') . '?', // Format kode yang akan digunakan.
                'length' => 3 // Jumlah digit yang akan digunakan sebagai nomor urut
            ]
        ];
    }
}
