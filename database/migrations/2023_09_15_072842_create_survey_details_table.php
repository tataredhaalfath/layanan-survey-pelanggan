<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('survey_details', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('answer')->nullable();
            $table->string('type');
            $table->string('prompt_data')->nullable();

            // relation to table survey (survey_code > survey_code)
            $table->string('survey_code');
            // $table->foreign('survey_code')->references('survey_code')->on('survey');

            // relstion to table master_questions (question_id > id)
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('master_questions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_details');
    }
};
