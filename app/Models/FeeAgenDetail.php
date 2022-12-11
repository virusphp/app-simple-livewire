<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeAgenDetail extends Model
{
    use HasFactory;

    public function feeAgen()
    {
        return $this->belongsTo(FeeAgen::class);
    }
}
