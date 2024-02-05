<?php

namespace App\Http\Controllers;

use App\Models\ProductAttributes;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function create()
    {
         return view('users.create');
    }

    public function list() {
        $users = User::join('unities as uu', 'uu.id', '=', 'users.unity_id')
            ->select(
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.username',
                'uu.unity_name'
            )
            ->get();

        return view('users.list', [
            'users' => $users
        ]);
    }

    public function edit($userId) {
        $quantityCode = 'QTY';
        $unityCode = 'UNITY';

        $user = User::find($userId);
        $movements = Products::join('product_attributes as pa', 'pa.product_ref_id', '=', 'products.id')
            ->join('users as u', 'u.id', '=', 'pa.user_id')
            ->join('product_attributes as pa2', function ($join) use ($unityCode) {
                $join->on('pa2.product_ref_id', '=', 'products.id')
                    ->where('pa2.attribute_code', '=', $unityCode);
            })
            ->select(
                'pa.id',
                'pa.user_id',
                'pa.attribute_log',
                'pa.attribute_log_detail',
                DB::raw("CONCAT(products.product_num_intern, ' - ', products.product_name) AS product_name"),
                'pa.attribute_date_start as registred_at',
                'pa2.attribute_value as unity'
            )
            ->where('pa.attribute_code', '=', $quantityCode)
            ->where('pa.user_id', '=', $userId)
            ->orderBy('pa.created_at', 'desc')
            ->get();

        return view('users.overview', [
            'user' => $user,
            'movements' => $movements
        ]);
    }
}
