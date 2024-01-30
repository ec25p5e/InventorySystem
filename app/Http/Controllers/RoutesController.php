<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\Unities;

class RoutesController extends Controller
{
    protected $namespace = 'App\Http\Controllers\RoutesController';

    public function index(){
        return view('routes.list');
    }

    public function create() {
        $unities = Unities::all();
        $roles = Roles::all();

        return view('routes.config', [
            'unities' => $unities,
            'roles' =>$roles,
        ]);
    }

    public function store(Request $request) {

    }
}
