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

    public function transaksi()
    {
        return $this->hasMany(PacketTransaction::class, 'user_id');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'kode_agen');
    }

    public function tarif()
    {
        return $this->hasMany(Tarif::class, 'user_id');
    }

    public function tariflokal()
    {
        return $this->hasMany(TarifLokal::class, 'user_id');
    }

    public function topup()
    {
        return $this->hasMany(TopupSaldo::class, 'user_id');
    }

    public function saldo()
    {
        return $this->hasOne(Saldo::class);
    }

    public function packets()
    {
        return $this->hasMany(PacketTransaction::class);
    }

    public function fees()
    {
        return $this->hasMany(FeeAgen::class);
    }

    public function deleteRole($params)
    {
        return DB::table('model_has_roles')->where('model_id', $params->id)->delete();
    }

    public function role() {
        return $this->belongsTo('App\Role', 'role');
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
