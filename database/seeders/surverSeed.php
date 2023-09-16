<?php

namespace Database\Seeders;

use App\Models\Survey;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class surverSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payloadSurvey = [
            'id' =>  Str::uuid()->toString(),
            "name" => "test",
            "email" => 'test'
        ];

        Survey::create($payloadSurvey);
    }
}
