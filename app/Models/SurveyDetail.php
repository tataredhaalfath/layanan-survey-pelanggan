<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyDetail extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    protected $fillable = ['id', 'question', 'answer', 'type', 'prompt_data', 'survey_id', 'question_id'];

    protected $quarded = [];

    public function question()
    {
        $this->belongsTo(MasterQuestion::class, 'question_id', 'id');
    }

    public function surver()
    {
        $this->belongsTo(Survey::class, 'survey_id', 'id');
    }
}
