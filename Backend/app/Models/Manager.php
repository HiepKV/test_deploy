<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $fillable = [
        'manager_name',
        'gender',
        'reason',
        'niece',
    ];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
