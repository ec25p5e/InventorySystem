<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $middleware = ['auth:api'];

    public function deleteProductAttribute(Request $request) {
        return response()->view('errors.500', [], 500);
    }
}
