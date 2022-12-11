<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = "countries";

    protected $primaryKey = "kode_negara";
    public $timestamps = true;

    protected $fillable = [
        'id', 'kode_negara', 'nama_negara'
    ];
}
