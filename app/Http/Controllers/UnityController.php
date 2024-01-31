<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnityController extends Controller
{
    public function change(Request $request) {
        $request->validate([
            'unity_ref' => 'required|int'
        ]);
        $newUnityId = $request->input('unity_ref');
        $userRow = User::where('id', Auth::id())->first();

        if($userRow->unity_id != $newUnityId) {
            $userRow->unity_id = $newUnityId;
            $userRow->save();

            return view(getRoute(Auth::id(), 'DASHBOARD'));
        }
    }
}
