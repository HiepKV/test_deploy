<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';
    protected $fillable = ['id','username', 'role', 'password','memo','created_at'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
