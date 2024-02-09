<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAttributes;
use Illuminate\Http\Request;

class UserAttributesController extends Controller
{
    public function showHistory($userId, $attrCode) {
        $user = User::find($userId);
        $histories = UserAttributes::select('user_attributes_def.def_code', 'user_attributes.attribute_value', 'user_attributes.user_mod', 'user_attributes.attribute_date_start', 'user_attributes.attribute_date_end')
            ->where('user_id', 1)
            ->where('attribute_code', 'ADDRESS')
            ->with('userAttributesDef')
            ->get();

        return view('users.attributeHistory', [
            'user' => $user,
            'histories' => $histories,
        ]);
    }
}
