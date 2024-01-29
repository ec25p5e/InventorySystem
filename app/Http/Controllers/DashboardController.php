<?php

namespace App\Http\Controllers;

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
}
