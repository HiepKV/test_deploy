<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'manager_id',
        'phone_number',
        'email',
        'company_created_by',
    ];

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }
    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }
}
