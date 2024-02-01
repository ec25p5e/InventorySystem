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
        $results = null;

        $rules = [
            'unity_code' => 'required|string',
            'role_code' => 'required|numeric|min:0',
            'route_code' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if(!$validator->fails()) {
            $unityId = $request->query('unity_code');
            $roleId= $request->query('role_code');
            $routeCode = $request->query('route_code');
        }


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
            ->where('rc.unity_id', 1)
            ->paginate(10);

        return view('routes.list', [
            'unities' => $unities,
            'roles' => $roles,
            'routes' => $routes,
            'results' => $results
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
