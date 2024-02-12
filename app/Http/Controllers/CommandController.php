<?php

namespace App\Http\Controllers;

use App\Models\Unities;
use App\Models\User;
use App\Models\Vars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CommandController extends Controller
{
    public function create() {
        return view('vars.create');
    }

    public function update($variableId) {
        $var = Vars::where('id', $variableId)->first();
        return view('vars.create', [
            'variableDetails' => $var
        ]);
    }

    public function list(Request $request) {
        $vars = null;
        $unities = Unities::with('childrenRecursive')
            ->whereNull('unity_ref_id')
            ->get();
        $key[] = null;

        $unityRules = [
            'unity_id' => 'required|int'
        ];
        $validatorUnity = Validator::make($request->all(), $unityRules);

        if(!$validatorUnity->fails()) {
            $key['unity_id'] = $request->input('unity_id');
            $unities = Unities::where('id', $key['unity_id'])->get();
            $vars = Vars::where('command_unity_ref', $key['unity_id'])->get();
        }

        return view('vars.list', [
            'unities' => $unities,
            'variables' => $vars,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'command_code' => 'required|string',
            'command_name' => 'required|string',
            'command_signature' => 'required|string',
            'editor' => 'required|string'
        ]);
        $userId = Auth::id();
        $userRow = User::where('id', $userId)->first();
        $directory = app_path('Console/Commands');

        $data = [
            'command_code' => $request->input('command_code'),
            'command_name' => $request->input('command_name'),
            'command_description' => $request->input('command_description'),
            'command_signature' => $request->input('command_signature'),
            'command_options' => $request->input('command_options'),
            'command_body' => $request->input('editor') ?? ' ',
            'command_unity_ref' => $userRow->unity_id,
            'command_user_ref' => $userId,
            'command_date_start' => now(),
            'command_date_end' => null,
        ];

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }

        $filePath = $directory . '/' . $data['command_code'] . '.php';

        // Registra la variabile nel db
        Vars::create($data);
        File::put($filePath, $data['command_body']);

        // Ritorna alla schermata di creazione
        return redirect()->back();
    }

    public function execute(Request $request) {
        $result = Artisan::call('variables:get_product_qty', [
            'product_id' => 5048
        ]);
    }

    public function searchVar(Request $request) {
        $request->validate([
            'query' => 'required|string'
        ]);

        $userId = Auth::id();
        $userRow = User::find($userId)->first();
        $queryString = $request->input('query');

        $results = Vars::where(function($query) use ($queryString) {
            $query->whereRaw('LOWER(command_code) LIKE ?', ['%' . $queryString . '%'])
                ->orWhereRaw('LOWER(command_name) LIKE ?', ['%' . $queryString . '%']);
        })->where(function($query) use ($userId, $userRow) {
            $query->where('command_unity_ref', $userRow->unity_id)
                ->orWhere('command_user_ref', $userId);
        })
            ->get();

        return response()->json($results);
    }
}
