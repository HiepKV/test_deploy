<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $fillable = ['question_no','question_text', 'question_type', 'survey_id', 'required'];
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
    public function choices()
    {
        return $this->hasMany(Choice::class);
    }
    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
