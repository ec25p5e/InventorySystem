<?php

namespace App\Http\Controllers;

use App\Models\PopulationFilters;
use App\Models\Populations;
use App\Models\ProductAttributes;
use App\Models\Products;
use App\Models\ReportModelColumns;
use App\Models\ReportModels;
use App\Models\Unities;
use App\Models\User;
use App\Models\Vars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReportsController extends Controller
{
    public function index(Request $request) {
        $unities = Unities::with('childrenRecursive')->whereNull('unity_ref_id')->get();
        $populations = null;
        $reports = null;
        $reportColumns = null;
        $query = Products::where('product_end', null);
        $columnsValue = null;
        $key[] = null;

        $unityRules = [
            'unity_id' => 'required|int'
        ];

        $partialRules = [
            'unity_id' => 'required|int',
            'population_id' => 'required|int',
        ];

        $completeValidator = [
            'unity_id' => 'required|int',
            'population_id' => 'required|int',
            'report_mod_id' => 'required|int'
        ];

        $validatorUnity = Validator::make($request->all(), $unityRules);
        $validatorPartial = Validator::make($request->all(), $partialRules);
        $validatorComplete = Validator::make($request->all(), $completeValidator);

        if(!$validatorUnity->fails()) {
            $key['unity_id'] = $request->input('unity_id');

            $unities = Unities::where('id', $key['unity_id'])->get();
            $populations = Populations::where('unity_id', $key['unity_id'])->get();
        }

        if(!$validatorPartial->fails()) {
            $key['unity_id'] = $request->input('unity_id');
            $key['population_id'] = $request->input('population_id');

            $reports = ReportModels::where('unity_id', $key['unity_id'])->get();
        }

        if(!$validatorComplete->fails()) {
            $key['unity_id'] = $request->input('unity_id');
            $key['population_id'] = $request->input('population_id');
            $key['report_id'] = $request->input('report_mod_id');

            $unities = Unities::where('id', $key['unity_id'])->get();
            $reportColumns = ReportModelColumns::where('report_id', $key['report_id'])
                ->join('vars', 'vars.id', '=', 'report_model_columns.command_id')
                ->select('report_model_columns.*', 'vars.command_code')
                ->get();

            /*
             * Logica per costruire la query
             */
            $allFilterByPopulations = PopulationFilters::where('population_id', $key['population_id'])->get();
            $query = null;

            foreach($allFilterByPopulations as $filter) {
                $explodedCode = explode(':', $filter->code_ref);
                $explodeValue = explode(':', $filter->filter_value);

                $tableRef = $explodedCode[0];
                $codeRef = $explodedCode[1];

                $compilationType = $explodeValue[0];
                $compilationId = $explodeValue[1];

                switch($tableRef) {
                    case 'product_attributes':
                        $query = ProductAttributes::query();

                        $query->where('attribute_code', $filter->filter_operator, getAttributeIdByCode($codeRef))
                            ->where('attribute_value', $filter->filter_operator, $compilationId)
                            ->where('attribute_date_end', '=', null);
                        break;
                    case 'products':
                        $query = Products::query();
                        $query->where($codeRef, $filter->filter_operator, $compilationId);

                        break;
                }
            }

            $columnsValue = function($commandName, $signature, $ref) {
                $signature = explode('&', $signature);
                $arguments = array_combine($signature, $ref);
                $commandName = getSettings('DEFAULT_VAR_PREFIX') . ':' . $commandName;

                return Artisan::call($commandName, $arguments);
            };
        }

        return view('reports.list', [
            'unities' => $unities,
            'reports' => $reports,
            'populations' => $populations,
            'parameters' => $key,
            'reportColumns' => $reportColumns,
            'reportRow' => $query->distinct()->get(),
            'columnsValue' => $columnsValue
        ]);
    }

    public function createModel() {
        $unities = Unities::all();
        $users = User::all();

        return view('reports.createModel', [
            'unities' => $unities,
            'users' => $users
        ]);
    }

    public function editReportModel($modelId) {
        $model = ReportModels::find($modelId)->get();
        $unities = Unities::all();
        $users = User::all();

        return view('reports.createModel', [
            'modelDetails' => $model,
            'unities' => $unities,
            'users' => $users
        ]);
    }

    public function storeModel(Request $request) {
        $unities = Unities::all();
        $users = User::all();
        $row[] = null;

        if(hasRole(Auth::id(), 'ADMIN') > 0) {
            $request->validate([
                'report_name' => 'required|string',
                'report_description' => 'required|string',
            ]);

            $reportName = $request->input('report_name');
            $reportDescription = $request->input('report_description');
            $reportUnity = $request->input('unity_id');
            $reportUser = $request->input('user_id');

            $row = [
                'report_name' => $reportName,
                'report_description' => $reportDescription,
                'unity_id' => getUserActualUnity(Auth::id()),
                'user_id' => $reportUser
            ];
        } else {
            $request->validate([
                'report_name' => 'required|string',
                'report_description' => 'required|string'
            ]);

            $reportName = $request->input('report_name');
            $reportDescription = $request->input('report_description');

            $row = [
                'report_name' => $reportName,
                'report_description' => $reportDescription,
                'unity_id' => getUserActualUnity(Auth::id()),
                'user_id' => Auth::id()
            ];
        }

        $results = ReportModels::create($row);
        return view('reports.createModel', [
            'unities' => $unities,
            'users' => $users,
            'reportDetails' => $results
        ])->with('messageFormModel', 'Modello creato con successo');
    }

    public function storeModelColumn(Request $request) {
        $request->validate([
            'report_ref_id' => 'required|int',
            'command_code' => 'required|string',
            'command_name' => 'required|string',
            'command_signature' => 'required|string'
        ]);

        $varCode = $request->input('command_code');
        $varRow = Vars::where('command_code', $varCode)->first();
        $varId = $varRow->id;
        $varName = $varRow->command_name;

        $row = [
            'report_id' => $request->input('report_ref_id'),
            'command_id' => $varId,
            'column_name' => $varName,
            'column_position' => 0,
            'column_signature' => $request->input('command_signature'),
        ];

        ReportModelColumns::create($row);
        return redirect()->back()->with('messageFormColumn', 'Colonna aggiunta con successo!');
    }
}
