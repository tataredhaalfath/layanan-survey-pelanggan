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
    public function index()
    {
        $title = "Data Survey Pelanggan";

        return view("pages.dashboard.survey", compact('title'));
    }

    // API

    public function dataTable(Request $request)
    {
        $query = Survey::query();

        if ($request->query('search')) {
            $searchValue = $request->query('search')['value'];
            $query->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
            });
        }

        $data = $query->orderBy('created_at', 'desc')
            ->skip($request->query('start'))
            ->limit($request->query('length'))
            ->get();

        $output = $data->map(function ($s) {
            $action = "<div class='dropdown-primary dropdown open'>
                            <button class='btn btn-sm btn-primary dropdown-toggle waves-effect waves-light' id='dropdown-{$s->id}' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'>
                                Aksi
                            </button>
                            <div class='dropdown-menu' aria-labelledby='dropdown-{$s->id}' data-dropdown-out='fadeOut'>
                                <a class='dropdown-item' href='/admin/survey/detail/{$s->id}' title='Detail'>Detail</a>
                                <a class='dropdown-item' onclick='return removeData(\"{$s->id}\");' href='javascript:void(0)' title='Remove'>Hapus</a>
                            </div>
                        </div>";

            return [
                'action' => $action,
                'name' => $s->name,
                'email' => $s->email,
            ];
        });

        $total = Survey::count();

        return response()->json([
            'draw' => $request->query('draw'),
            'recordsFiltered' => $total,
            'recordsTotal' => $total,
            'data' => $output,
        ]);
    }

    public function getDetail(Request $requrest, $id)
    {
        $data = Survey::with(['surveyDetail' => function ($query) {
            $query->orderBy('order_data', 'asc');
        }])->find($id);

        if (!$data) {
            return response()->json([
                'status' => 404,
                'message' => 'Data Survey tidak ditemukan!'
            ]);
        }

        return response()->json([
            'status' => 200,
            'data' => $data,
        ]);
    }

    public function destroy(Request $request)
    {
        $survey = Survey::find($request->input('id'));
        if (!$survey) {
            return response()->json([
                'status' => 404,
                'message' => "Data survey tidak ditemukan"
            ]);
        }

        $survey->delete();
        return response()->json([
            'status' => 200,
            'message' => "Data survey berhasil dihapus"
        ]);
    }

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
            $orderData = 0;
            foreach ($data as $key => $value) {
                if ($key !== "name" && $key !== "email") {
                    $masterQuestion = MasterQuestion::find($key);
                    if ($masterQuestion) {
                        $orderData += 1;
                        array_push($payloadSurveyDetail, [
                            'id' =>   Str::uuid()->toString(),
                            'question' => $masterQuestion->question,
                            'answer' => $value,
                            'type' => $masterQuestion->type,
                            'prompt_data' => $masterQuestion->prompt_data,
                            'order_data' => $orderData,
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
