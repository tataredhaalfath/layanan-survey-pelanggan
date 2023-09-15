<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterQuestion extends Model
{
    use HasFactory;

    protected $quarded = [];

    public function surveyDetail()
    {
        $this->hasMany(SurveyDetail::class, 'question_id', 'id');
    }
}
