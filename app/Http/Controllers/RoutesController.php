<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\RoutesConf;
use App\Models\Unities;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Ramsey\Uuid\Type\Integer;

class RoutesController extends Controller
{
    protected $namespace = 'App\Http\Controllers\RoutesController';

    public function index(Request $request){
        $unities = Unities::all();
        $roles = Roles::all();
        $routes = RoutesConf::pluck('route_code');
        $key['unity_code'] = null;
        $key['role_code'] = null;
        $key['route_code'] = null;
        $results = null;

        $globalRules = [
            'unity_code' => 'required|int',
            'role_code' => 'required|int',
            'route_code' => 'required|string'
        ];

        $partialRules1 = [
            'unity_code' => 'required|int',
            'role_code' => 'required|int',
        ];

        $partialRules2 = [
            'unity_code' => 'required|int',
            'route_code' => 'required|string'
        ];

        $partialRules3 = [
            'role_code' => 'required|int',
            'route_code' => 'required|string'
        ];

        $unityCodeRules = [
            'unity_code' => 'required|int',
        ];

        $roleCodeRules = [
            'role_code' => 'required|int',
        ];

        $routeCodeRules = [
            'route_code' => 'required|string'
        ];

        $unityValidator = Validator::make($request->all(), $unityCodeRules);
        $roleValidator = Validator::make($request->all(), $roleCodeRules);
        $routeValidator = Validator::make($request->all(), $routeCodeRules);
        $globalValidator = Validator::make($request->all(), $globalRules);
        $partialValidator1 = Validator::make($request->all(), $partialRules1);
        $partialValidator2 = Validator::make($request->all(), $partialRules2);
        $partialValidator3 = Validator::make($request->all(), $partialRules3);

        if(!$unityValidator->fails()) {
            $key['unity_code'] = $request->input('unity_code');

            $results = DB::table('routes_conf as rc')
                ->select(
                    'rc.id',
                    'rc.route_code',
                    'r.role_name as route_role',
                    'u.unity_name as route_unity',
                    'rc.route_name',
                    'rc.route_uri',
                    'rc.route_method',
                    'rc.route_controller',
                    'rc.controller_method',
                    'rc.route_middleware'
                )
                ->join('roles as r', 'rc.role_id', '=', 'r.id')
                ->join('unities as u', 'u.id', '=', 'rc.unity_id')
                ->where('rc.unity_id', $key['unity_code'])
                ->paginate(10);
        }

        if(!$roleValidator->fails()) {
            $key['role_code'] = $request->input('role_code');

            $results = DB::table('routes_conf as rc')
                ->select(
                    'rc.id',
                    'rc.route_code',
                    'r.role_name as route_role',
                    'u.unity_name as route_unity',
                    'rc.route_name',
                    'rc.route_uri',
                    'rc.route_method',
                    'rc.route_controller',
                    'rc.controller_method',
                    'rc.route_middleware'
                )
                ->join('roles as r', 'rc.role_id', '=', 'r.id')
                ->join('unities as u', 'u.id', '=', 'rc.unity_id')
                ->where('rc.role_id', $key['role_code'])
                ->paginate(10);
        }

        if(!$routeValidator->fails()) {
            $key['route_code'] = $request->input('route_code');

            $results = DB::table('routes_conf as rc')
                ->select(
                    'rc.id',
                    'rc.route_code',
                    'r.role_name as route_role',
                    'u.unity_name as route_unity',
                    'rc.route_name',
                    'rc.route_uri',
                    'rc.route_method',
                    'rc.route_controller',
                    'rc.controller_method',
                    'rc.route_middleware'
                )
                ->join('roles as r', 'rc.role_id', '=', 'r.id')
                ->join('unities as u', 'u.id', '=', 'rc.unity_id')
                ->where('rc.route_code', $key['route_code'])
                ->paginate(10);
        }

        if(!$globalValidator->fails()) {
            $key['unity_code'] = $request->input('unity_code');
            $key['role_code'] = $request->input('role_code');
            $key['route_code'] = $request->input('role_code');

            $results = DB::table('routes_conf as rc')
                ->select(
                    'rc.id',
                    'rc.route_code',
                    'r.role_name as route_role',
                    'u.unity_name as route_unity',
                    'rc.route_name',
                    'rc.route_uri',
                    'rc.route_method',
                    'rc.route_controller',
                    'rc.controller_method',
                    'rc.route_middleware'
                )
                ->join('roles as r', 'rc.role_id', '=', 'r.id')
                ->join('unities as u', 'u.id', '=', 'rc.unity_id')
                ->where('rc.unity_id', $key['unity_code'])
                ->orWhere('rc.role_id', $key['role_code'])
                ->orWhere('rc.route_code', $key['route_code'])
                ->paginate(10);
        } else if(!$partialValidator1->fails() && $globalValidator->fails()) {
            $key['unity_code'] = $request->input('unity_code');
            $key['role_code'] = $request->input('role_code');

            $results = DB::table('routes_conf as rc')
                ->select(
                    'rc.id',
                    'rc.route_code',
                    'r.role_name as route_role',
                    'u.unity_name as route_unity',
                    'rc.route_name',
                    'rc.route_uri',
                    'rc.route_method',
                    'rc.route_controller',
                    'rc.controller_method',
                    'rc.route_middleware'
                )
                ->join('roles as r', 'rc.role_id', '=', 'r.id')
                ->join('unities as u', 'u.id', '=', 'rc.unity_id')
                ->where('rc.unity_id', $key['unity_code'])
                ->where('rc.role_id', $key['role_code'])
                ->paginate(10);
        } else if(!$partialValidator2->fails() && $globalValidator->fails()) {
            $key['unity_code'] = $request->input('unity_code');
            $key['route_code'] = $request->input('route_code');

            $results = DB::table('routes_conf as rc')
                ->select(
                    'rc.id',
                    'rc.route_code',
                    'r.role_name as route_role',
                    'u.unity_name as route_unity',
                    'rc.route_name',
                    'rc.route_uri',
                    'rc.route_method',
                    'rc.route_controller',
                    'rc.controller_method',
                    'rc.route_middleware'
                )
                ->join('roles as r', 'rc.role_id', '=', 'r.id')
                ->join('unities as u', 'u.id', '=', 'rc.unity_id')
                ->where('rc.unity_id', $key['unity_code'])
                ->where('rc.route_code', $key['route_code'])
                ->paginate(10);
        } else if(!$partialValidator3->fails() && $globalValidator->fails()) {
            $key['role_code'] = $request->input('role_code');
            $key['route_code'] = $request->input('role_code');

            $results = DB::table('routes_conf as rc')
                ->select(
                    'rc.id',
                    'rc.route_code',
                    'r.role_name as route_role',
                    'u.unity_name as route_unity',
                    'rc.route_name',
                    'rc.route_uri',
                    'rc.route_method',
                    'rc.route_controller',
                    'rc.controller_method',
                    'rc.route_middleware'
                )
                ->join('roles as r', 'rc.role_id', '=', 'r.id')
                ->join('unities as u', 'u.id', '=', 'rc.unity_id')
                ->where('rc.role_id', $key['role_code'])
                ->where('rc.route_code', $key['route_code'])
                ->paginate(10);
        }

        return view('routes.list', [
            'unities' => $unities,
            'roles' => $roles,
            'routes' => $routes,
            'results' => $results,
            'formFields' => $key
        ]);
    }

    public function create(Request $request) {
        $unities = Unities::with('childrenRecursive')->whereNull('unity_ref_id')->get();
        $roles = Roles::all();
        $key[] = null;

        $unityIdRules = [
            'unity_id' => 'required|numeric|min:0'
        ];

        $formCreationRules = [
            '_token' => 'required|string',
            'unity_id' => 'required|int',
            'route_code' => 'required|string',
            'route_controller' => 'required|string',
            'controller_method' => 'required|string',
            'role_code' => 'required|int',
            'route_name' => 'required|string',
            'route_method' => 'required|string',
            'btnForm' => 'required|int'
        ];

        $validatorUnityId = Validator::make($request->all(), $unityIdRules);
        $validatorForm = Validator::make($request->all(), $formCreationRules);

        if($validatorForm->fails() && $validatorUnityId->fails()) {
            Session::remove('routes_creation');
            $routes = [];
        } else {
            $routes = Session::get('routes_creation');
        }

        if(!$validatorUnityId->fails()) {
            $key['unity_id'] = $request->input('unity_id');
            $unities = Unities::where('id', $key['unity_id'])->get();
        }

        if(!$validatorForm->fails()) {
            if($request->input('btnForm') == 2) { // Modalità propaga
                // Prendi tutte le unità sotto quella di riferimento
                $unitiesToPropagte = DB::table('unities_tree')
                    ->select('unity_id')
                    ->where('unity_ref', $key['unity_id'])
                    ->distinct()
                    ->pluck('unity_id');



            }


            $key['unity_id'] = $request->input('unity_id');
            $key['route_code'] = $request->input('route_code');
            $key['route_controller'] = $request->input('route_controller');
            $key['controller_method'] = $request->input('controller_method');
            $key['role_code'] = $request->input('role_code');
            $key['route_name'] = $request->input('route_name');
            $key['route_method'] = $request->input('route_method');
            $key['btnForm'] = $request->input('btnForm');
            $key['auto_id'] = Str::random(4);

            $row = [
                'auto_id' => $key['auto_id'],
                'unity_id' => $key['unity_id'],
                'route_code' => $key['route_code'],
                'role_code' => $key['role_code'],
                'route_method' => $key['route_method'],
                'route_name' => $key['route_name'],
                'route_controller' => $key['route_controller'],
                'controller_method' => $key['controller_method']
            ];

            $routes[] = $row;
            $convertedArray = collect($routes);
            Session::put('routes_creation', $convertedArray->unique()->values()->all());
        }

        return view('routes.config', [
            'unities' => $unities,
            'roles' =>$roles,
            'parameters' => $key,
            'routes' => $routes,
            'validationCompleteResult' => $validatorForm->fails()
        ]);
    }

    public function update($routeId) {
        $record = RoutesConf::find($routeId);
        $unities = Unities::with('childrenRecursive')->whereNull('unity_ref_id')->get();
        $roles = Roles::all();

        return view('routes.config', [
            'record' => $record,
            'roles' =>$roles,
            'unities' => $unities
        ]);
    }

    public function store(Request $request) {

    }
}
