<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Account extends Authenticatable implements JWTSubject
{
    use notifiable;
    protected $table = 'accounts';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';
    protected $fillable = ['id','username', 'role', 'password','memo','created_at'];

    protected $hidden = [
        'password',
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'role' => $this->role,
        ];
    }

}
