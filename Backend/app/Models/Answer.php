<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';
    protected $fillable = [
        'intent_id',
        'response_text',
        'company_name',
        'phone_number',
        'email',
    ];
    public $timestamps = false;
    public function intent()
    {
        return $this->belongsTo(Intent::class);
    }
}
