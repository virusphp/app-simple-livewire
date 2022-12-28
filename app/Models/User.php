<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'kode_agen',
        'last_login',
        'is_active'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'kode_agen');
    }

    public function saldo()
    {
        return $this->hasOne(Saldo::class);
    }

    public function pasiens()
    {
        return $this->hasMany(Pasien::class);
    }

    public function scopeAgen($query)
    {
         return $query->role('agen');
    }

    public function scopePencarian($query, $search)
    {
        return $query->when($search, function($query, $search) {
            $query->where('nama', 'like', "%{$search}%");
        });
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($user) {
            $user->profile->delete();
        });
    }

}
