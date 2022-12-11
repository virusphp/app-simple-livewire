<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeAgen extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_agen', 'area_agen', 'type_fee', 'nilai', 'kode_negara'
    ];

    public function feeDetails()
    {
        return $this->hasMany(FeeAgenDetail::class);
    }

    public function agen()
    {
        return $this->belongsTo(Profile::class);
    }
}
