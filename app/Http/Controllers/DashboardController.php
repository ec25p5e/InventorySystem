<?php

namespace App\Http\Controllers;

use App\Helpers\SettingsHelper;
use App\Models\ProductAttributes;
use App\Models\ProductAttributesDef;
use App\Models\Products;
use App\Models\Unities;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index() {
        return view('dashboard.index');
    }

    public function admin() {
        return view('dashboard.admin');
    }

    public function segretariato() {
        return view('dashboard.segretariato');
    }

    public function teacher() {
        return view('dashboard.teacher');
    }
}
