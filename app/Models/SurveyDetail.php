<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyDetail extends Model
{
    use HasFactory;

    protected $quarded = [];

    public function question()
    {
        $this->belongsTo(MasterQuestion::class, 'question_id', 'id');
    }

    public function surver()
    {
        $this->belongsTo(Survey::class, 'survey_code', 'survey_code');
    }
}
