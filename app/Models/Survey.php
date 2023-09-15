<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $quarded = [];

    public function surveyDetail()
    {
        return $this->hasMany(SurveyDetail::class, 'survey_id', 'id');
    }
}
