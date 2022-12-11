<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Virusphp\AutoNumber\AutoNumberTrait;

class GudangHub extends Model
{
    use AutoNumberTrait;

    use HasFactory;

    protected $fillable = [
        'kode_gudang', 'regency_id', 'nama_gudang'
    ];

    protected $primaryKey = "kode_gudang";

    protected $keyType = "string";

    public function getAutoNumberOptions()
    {
        return [
            'kode_gudang' => [
                'format' => 'GD' . date('y') . '?', // Format kode yang akan digunakan.
                'length' => 2 // Jumlah digit yang akan digunakan sebagai nomor urut
            ]
        ];
    }

    public function kota()
    {
        return $this->belongsTo(Regency::class, 'regency_id');
    }

    public function scopeLatest($query) 
    {
        return $query->orderBy('created_at', 'DESC');
    }
}
