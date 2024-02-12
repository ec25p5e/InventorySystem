<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\RoutesConf;
use App\Models\Unities;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Ramsey\Uuid\Type\Integer;

class RoutesController extends Controller
{
    protected $namespace = 'App\Http\Controllers\RoutesController';
    private $sessionStorageName = 'routes_creation';

    public function index(Request $request){
        $unities = Unities::with('childrenRecursive')->whereNull('unity_ref_id')->get();
        $roles = Roles::all();
        $routes[] = null;

        $unityRules = [
            'unity_id' => 'required|int'
        ];

        $biFilterRules = [
            'unity_id' => 'required|int',
            'role_id' => 'required|int'
        ];

        $validatorUnityId = Validator::make($request->all(), $unityRules);
        $validatorBiFilterRule = Validator::make($request->all(), $biFilterRules);

        if(!$validatorUnityId->fails()) {
            $key['unity_id'] = $request->input('unity_id');
            $unities = Unities::where('id', $key['unity_id'])->get();

            $routes = RoutesConf::where('unity_id', $key['unity_id'])
                ->orderBy('route_code')
                ->get();
        }

        if(!$validatorBiFilterRule->fails()) {
            $key['unity_id'] = $request->input('unity_id');
            $key['role_id'] = $request->input('role_id');
            $roles = Roles::where('id', $key['role_id'])->get();

            $routes = RoutesConf::where('unity_id', $key['unity_id'])
                ->where('role_id', $key['role_id'])
                ->orderBy('route_code')
                ->get();
        }

        if($validatorBiFilterRule->fails() && $validatorUnityId->fails()){
            $roles = Roles::all();
            $key = null;
            $routes = null;
        }

        return view('routes.list', [
            'unities' => $unities,
            'roles' => $roles,
            'routes' => $routes,
            'parameters' => $key,
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
            'unity_id' => 'required|numeric',
            'route_code' => 'required|string',
            'route_controller' => 'required|string',
            'controller_method' => 'required|string',
            'role_code' => 'required|numeric',
            'route_name' => 'required|string',
            'route_method' => 'required|string',
            'is_menu' => 'required|numeric',
            'btnForm' => 'required|numeric'
        ];

        $validatorUnityId = Validator::make($request->all(), $unityIdRules);
        $validatorForm = Validator::make($request->all(), $formCreationRules);

        // Pulizia della tabella che contiene tutte le route in fase di creazione
        if($validatorForm->fails() && $validatorUnityId->fails()) {
            Session::remove($this->sessionStorageName);
            $routes = [];
        } else {
            $routes = Session::get($this->sessionStorageName);
        }

        // Filtro sull'unità selezionata e quelle sotto
        if(!$validatorUnityId->fails()) {
            $key['unity_id'] = $request->input('unity_id');
            $unities = Unities::where('id', $key['unity_id'])->get();
        }

        // Trattamento logica del form
        if(!$validatorForm->fails()) {
            if($request->input('btnForm') == 2) { // Modalità propaga
                // Prendi tutte le unità sotto quella di riferimento
                $unitiesToPropagate = DB::table('unitiesTreeHier as u1')
                    ->join('unitiesTreeHier as u2', 'u1.level', '>=', 'u2.level')
                    ->where('u2.id', $key['unity_id'])
                    ->select('u1.*')
                    ->get();

                foreach($unitiesToPropagate as $unity) {
                    $key['unity_id'] = $unity->id;
                    $key['route_code'] = $request->input('route_code');
                    $key['route_text'] = $request->input('route_text');
                    $key['route_controller'] = $request->input('route_controller');
                    $key['controller_method'] = $request->input('controller_method');
                    $key['role_code'] = $request->input('role_code');
                    $key['route_name'] = $request->input('route_name');
                    $key['route_method'] = $request->input('route_method');
                    $key['btnForm'] = $request->input('btnForm');
                    $key['auto_id'] = Str::random(4);
                    $key['is_menu'] = $request->input('is_menu');

                    $row = [
                        'auto_id' => $key['auto_id'],
                        'unity_id' => $key['unity_id'],
                        'route_code' => $key['route_code'],
                        'role_code' => $key['role_code'],
                        'route_method' => $key['route_method'],
                        'route_name' => $key['route_name'],
                        'route_controller' => $key['route_controller'],
                        'controller_method' => $key['controller_method'],
                        'route_text' => $key['route_text'],
                        'is_menu' => $key['is_menu']
                    ];

                    $routes[] = $row;
                    $convertedArray = collect($routes);
                    Session::put($this->sessionStorageName, $convertedArray->unique()->values()->all());
                }
            } else if($request->input('btnForm') == 1) { // Modalità singola aggiunta
                $key['unity_id'] = $request->input('unity_id');
                $key['route_code'] = $request->input('route_code');
                $key['route_text'] = $request->input('route_text');
                $key['route_controller'] = $request->input('route_controller');
                $key['controller_method'] = $request->input('controller_method');
                $key['role_code'] = $request->input('role_code');
                $key['route_name'] = $request->input('route_name');
                $key['route_method'] = $request->input('route_method');
                $key['btnForm'] = $request->input('btnForm');
                $key['auto_id'] = Str::random(4);
                $key['is_menu'] = $request->input('is_menu');

                $row = [
                    'auto_id' => $key['auto_id'],
                    'unity_id' => $key['unity_id'],
                    'route_code' => $key['route_code'],
                    'role_code' => $key['role_code'],
                    'route_method' => $key['route_method'],
                    'route_name' => $key['route_name'],
                    'route_controller' => $key['route_controller'],
                    'controller_method' => $key['controller_method'],
                    'route_text' => $key['route_text'],
                    'is_menu' => $key['is_menu']
                ];

                $routes[] = $row;
                $convertedArray = collect($routes);
                Session::put($this->sessionStorageName, $convertedArray->unique()->values()->all());
            }
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
        $routes = Session::get($this->sessionStorageName);

        foreach($routes as $route) {
            // Prendi il codice del ruolo per il middleware
            $middlewareRole = Roles::find($route['role_code']);
            $randomUri = Str::random(20);

            $row = [
                'route_code' => $route['route_code'],
                'role_id' => $route['role_code'],
                'unity_id' => $route['unity_id'],
                'route_name' => $route['route_name'] . '_' . $randomUri,
                'route_uri' => '/' . $randomUri,
                'route_method' => $route['route_method'],
                'route_controller' => $route['route_controller'],
                'controller_method' => $route['controller_method'],
                'route_middleware' => ('role:' . $middlewareRole->role_code),
                'route_text' => $route['route_text'],
                'is_menu' => $route['is_menu']
            ];

            RoutesConf::create($row);
        }

        Session::flash('success', 'Route create con successo');
        return redirect(getRouteUri(Auth::id(), 'ROUTE_CREATE'));
    }

    public function edit($routeId) {
        $route = RoutesConf::where('id', $routeId)->first();
        $roles = Roles::all();
        $unities = Unities::all();

        return view('routes.edit', [
            'unities' => $unities,
            'roles' => $roles,
            'routeDetails' => $route
        ]);
    }
}
