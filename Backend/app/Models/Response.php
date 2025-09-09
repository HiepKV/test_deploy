<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $table = 'responses';
    protected $fillable = ['answer_text', 'question_id', 'user_id','survey_id','choice_id'];
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function choice()
    {
        return $this->belongsTo(Choice::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

}
