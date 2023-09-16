<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\MasterQuestion;
use App\Models\Survey;
use App\Models\SurveyDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SurveyController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->all();
        $ini = null;

        try {
            DB::beginTransaction();
            // ambil dan simpan data survey
            $payloadSurvey = [
                'id' =>  Str::uuid()->toString(),
                'name' => $data['name'],
                'email' => $data['email']
            ];

            $survey = Survey::create($payloadSurvey);
            $ini =  [$payloadSurvey, $survey];

            // simpan data survey detail
            $payloadSurveyDetail = [];
            foreach ($data as $key => $value) {
                if ($key !== "name" && $key !== "email") {
                    $masterQuestion = MasterQuestion::find($key);
                    if ($masterQuestion) {
                        array_push($payloadSurveyDetail, [
                            'id' =>   Str::uuid()->toString(),
                            'question' => $masterQuestion->question,
                            'answer' => $value,
                            'type' => $masterQuestion->type,
                            'prompt_data' => $masterQuestion->prompt_data,
                            'survey_id' => $payloadSurvey['id'],
                            'question_id' => $masterQuestion->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            SurveyDetail::insert($payloadSurveyDetail);
            DB::commit();
            $final = [$payloadSurvey, $payloadSurveyDetail];
            return response()->json([
                'status' => 200,
                'message' => "Survey berhasil dikirim",
                'data' => $final,
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error($err);
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan: ' . $err->getMessage(),
                'data' => $ini,
            ]);
        }
    }
}
