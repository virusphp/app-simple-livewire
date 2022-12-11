<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Virusphp\AutoNumber\AutoNumberTrait;

class JenisPaket extends Model
{
    use AutoNumberTrait;

    use HasFactory;

    protected $fillable = [
        'kode_jenis', 'nama_jenis_paket'
    ];

    protected $primaryKey = "kode_jenis";

    protected $keyType = "string";

    public function getAutoNumberOptions()
    {
        return [
            'kode_jenis' => [
                'format' => 'KJ' . date('y') . '?', // Format kode yang akan digunakan.
                'length' => 2 // Jumlah digit yang akan digunakan sebagai nomor urut
            ]
        ];
    }
}
