<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\Unities;

class RoutesController extends Controller
{
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
}
