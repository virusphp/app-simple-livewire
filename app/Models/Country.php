<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = "countries";

    protected $primaryKey = "kode_negara";

    protected $keyType = "string";
    
    public $timestamps = true;

    protected $fillable = [
        'id', 'kode_negara', 'nama_negara'
    ];

    public function scopePencarian($query, $search)
    {
        return $query->when($search, function($q, $search) {
            $q->where('nama_negara', 'like', "%{$search}%");
        });
    }

    public function fees()
    {
        return $this->hasMany(FeeAgen::class, 'kode_negara', 'kode_negara');
    }

    public function tarif()
    {
        return $this->hasMany(Tarif::class, 'kode_negara','kode_negara');
    }

    public function setNamaNegaraAtrribute($value)
    {
        if(!empty($value)) $this->attribute['nama_negara'] = strtoupper($value);
    }

}
