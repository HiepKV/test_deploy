<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intent extends Model
{
    protected $table = 'intents';
    protected $fillable = [
      'intent_name',
      'examples',
        'survey_id'
    ];
    public $timestamps = false;
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
