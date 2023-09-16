<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterQuestion extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    protected $fillable = ['id', 'question', 'placeholder', 'type', 'prompt_data', 'isRequired'];

    protected $quarded = [];


    public function surveyDetail()
    {
        $this->hasMany(SurveyDetail::class, 'question_id', 'id');
    }
}
