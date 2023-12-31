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
        Schema::create('master_questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('question');
            $table->string('placeholder')->nullable();
            $table->string('type')->default('text');
            $table->string('prompt_data')->nullable();
            $table->boolean('isRequired')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_questions');
    }
};
