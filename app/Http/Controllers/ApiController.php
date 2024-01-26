<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $middleware = ['auth:api'];

    public function deleteProductAttribute(Request $request) {
        dd($request->input('product_attribute_id'));
    }

    public function updateUserRoles(Request $request) {

    }
}
