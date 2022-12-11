<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    use HasFactory;

    protected $table = "saldos";

    public $timestamps = true;

    protected $fillable = [
        'user_id', 'saldo', 'histori_saldo_id',
    ];

    public function history()
    {
        return $this->hasOne(HistoriSaldo::class, 'histori_saldo_id');
    }

    public function scopeSaldoAgen($query, $userAgen)
    {
        return $query->where('user_id', $userAgen);
    }
}
