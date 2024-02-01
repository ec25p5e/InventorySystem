<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\RoutesConf;
use App\Models\Unities;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    public function create() {
        $unities = Unities::all();
        $roles = Roles::all();

        return view('routes.config', [
            'unities' => $unities,
            'roles' =>$roles,
        ]);
    }

    public function update($routeId) {
        $record = RoutesConf::find($routeId);
        $unities = Unities::all();
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
