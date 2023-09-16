<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\MasterQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MasterQuestionController extends Controller
{
    public function index()
    {
        $title = "DATA PERTANYAAN";
        return view('pages.dashboard.question', compact('title'));
    }

    public function addQuestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'placeholder' => 'required',
            'type' => 'required',
            'prompt_data' => 'nullable',
            'isRequired' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()
            ]);
        };

        $data = $request->all();
        $uuid = Str::uuid()->toString();
        MasterQuestion::create([
            'id' => $uuid,
            'question' => $data['question'],
            'placeholder' => $data['placeholder'],
            'type' => $data['type'],
            'prompt_data' => $data['prompt_data'],
            'isRequired' => $data['isRequired']
        ]);

        return response()->json([
            'status' => 200,
            'message' => "Data Pertanyaan Berhasil Dibuat"
        ]);
    }

    public function dataTable(Request $request)
    {
        $query = MasterQuestion::query();

        if ($request->query('search')) {
            $searchValue = $request->query('search')['value'];
            $query->where(function ($query) use ($searchValue) {
                $query->where('question', 'like', '%' . $searchValue . '%');
            });
        }

        $data = $query->orderBy("created_at", "asc")
            ->skip($request->query('start'))
            ->limit($request->query("length"))
            ->get();

        $output = $data->map(function ($q) {

            $isRequired = $q->isRequired == 1 ? "<small class='pcoded-badge label label-success'>Harus Dijawab</small>" : "<small class='pcoded-badge label label-warning'>Optional</small>";
            $action = "<div class='dropdown-primary dropdown open'>
                            <button class='btn btn-sm btn-primary dropdown-toggle waves-effect waves-light' id='dropdown-{$q->uuid}' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'>
                                Aksi
                            </button>
                            <div class='dropdown-menu' aria-labelledby='dropdown-{$q->uuid}' data-dropdown-out='fadeOut'>
                                <a class='dropdown-item' onclick='return getData(this);' href='javascript:void(0);' title='Edit'>Edit</a>
                                <a class='dropdown-item' onclick='return removeData(\"{$q->uuid}\");' href='javascript:void(0)' title='Remove'>Hapus</a>
                            </div>
                        </div>";

            return [
                'action' => $action,
                'uuid' => $q->uuid,
                'question' => $q->question,
                'placeholder' => $q->placeholder,
                'type' => $q->type,
                'prompt_data' => $q->prompt_data,
                'isRequired' => $isRequired,
            ];
        });

        $total = MasterQuestion::count();

        return response()->json([
            'draw' => $request->query('draw'),
            'recordsFiltered' => $total,
            'recordsTotal' => $total,
            'data' => $output,
        ]);
    }

    public function list()
    {
        $data = MasterQuestion::orderBy('created_at', 'asc')->get();
        return response()->json([
            'status' => 200,
            'data' => $data,
        ]);
    }
}
