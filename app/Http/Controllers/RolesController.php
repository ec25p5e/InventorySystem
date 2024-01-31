<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use Couchbase\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index() {
        return view('roles.index');
    }

    public function userRoles() {
        $allRoles = Roles::all();
        $allUsers = User::all();

        return view('roles.user', [
            'roles' => $allRoles,
            'users' => $allUsers
        ]);
    }
}
