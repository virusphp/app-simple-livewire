<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Virusphp\AutoNumber\AutoNumberTrait;

class PacketTransaction extends Model
{
    // use HasFactory;
    use AutoNumberTrait;

    protected $format;
    protected $table = "packet_transactions";
    protected $primaryKey = "kode_transaksi_paket";
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'kode_transaksi_paket',
        'kode_agen',
        'no_shipping',
        'user_id',
        'asal_paket',
        'negara_penerima',
        'nama_pengirim',
        'nama_penerima',
        'telepon_pengirim',
        'telepon_penerima',
        'alamat_pengirim',
        'alamat_penerima',
        'kota_pengirim',
        'kota_penerima',
        'estimasi_pengiriman',
        'kode_pos',
        'jenis_paket',
        'berat_asli',
        'berat_paket',
        'tanggal_pengiriman',
        // 'tarif_lokal',
        'biaya_paket',
        'biaya_paket_agen',
        'fee_agen',
        'nama_barang',
        'harga_barang',
        'status',
        'catatan',
        'bukti_pengiriman',
        'bukti_penerimaan'
    ];

    public function details()
    {
        return $this->hasMany(PacketTransactionDetail::class, 'kode_transaksi_paket', 'kode_transaksi_paket');
    }

    public function barangDetails()
    {
        return $this->hasMany(PacketTransactionBarangDetail::class, 'kode_transaksi_paket', 'kode_transaksi_paket');
    }

    public function historySaldo()
    {
        return $this->hasOne(HistoriSaldo::class, 'kode_transaksi', 'kode_transaksi_paket');
    }

    public function tracking()
    {
        return $this->hasOne(Tracking::class, 'kode_transaksi_paket', 'kode_transaksi_paket');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePaketNow($query, $value)
    {
        return $query->whereDate('created_at', tanggal($value));
    }

    public function negara()
    {
        return $this->belongsTo(Country::class);
    }

    public function setKodeTransaksiPaketAttribute($value)
    {
        if ($value != null) {
            $this->attributes['kode_transaksi_paket'] = $value;
            $this->format = [
                'format' => $value
            ];
            // dd($value, $this->format);
        } else {
            $this->format = [
                'format' => 'RJP' . '?', // Format kode yang akan digunakan.
                'length' => 7 // Jumlah digit yang akan digunakan sebagai nomor urut
            ];
        }
    }

    public function getAutoNumberOptions()
    {
        return [
            'kode_transaksi_paket' => $this->format
        ];
    }
}
