<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    protected $table = 'choices';
    protected $fillable = ['choice_text', 'question_id'];
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
