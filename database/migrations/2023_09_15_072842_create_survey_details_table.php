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
            $table->uuid('id')->primary();
            $table->string('question');
            $table->string('answer')->nullable();
            $table->string('type');
            $table->string('prompt_data')->nullable();
            $table->integer('order_data')->default(1);
            // relation to table survey (survey_id > id)
            $table->uuid('survey_id');
            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');

            // relstion to table master_questions (question_id > id)
            $table->uuid('question_id');
            $table->foreign('question_id')->references('id')->on('master_questions')->onDelete('cascade');
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
