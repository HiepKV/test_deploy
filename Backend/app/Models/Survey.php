<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = 'surveys';
    protected $fillable = [
        'survey_title',
        'survey_content',
        'user_id',
        'company_id',
        'status',
        'response_count',
        'keyword',
        'prefectures',
        'hero_image',
        'start_date',
        'end_date',
        'description',
        'created_at',
        'sent_count',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function responses()
    {
        return $this->hasMany(Response::class);
    }
    public function intents()
    {
        return $this->hasMany(Intent::class);
    }
}
