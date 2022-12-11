<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Virusphp\AutoNumber\AutoNumberTrait;

class PickupTransaction extends Model
{
    use AutoNumberTrait;

    protected $format;
    protected $table = "pickup_transactions";
    protected $primaryKey = "kode_pickup";
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'kode_pickup',
        'tanggal_pickup',
        'asal_pickup',
        'tujuan_pickup',
        'jumlah_paket',
        'penanggung_jawab',
        'keterangan',
        'status',
        'kode_agen'
    ];

    public function pickupDetails()
    {
        return $this->hasMany(PickupTransactionDetail::class, 'kode_pickup', 'kode_pickup');
    }

    public function getAutoNumberOptions()
    {
        return [
            'kode_pickup' => [
                'format' => 'PK' . date('Ymd') . '?', // Format kode yang akan digunakan.
                'length' => 3 // Jumlah digit yang akan digunakan sebagai nomor urut
            ]
        ];
    }
}
