<?php

namespace App\Http\Controllers;

use App\Models\ProductAttributes;
use http\Env\Response;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function deleteProductAttribute(Request $request) {
        $request->validate([
            'product_attribute_id' => 'required|int'
        ]);

        $attributeToDelete = ProductAttributes::find($request->input('product_attribute_id'));

        if($attributeToDelete) {
            $attributeToDelete->delete();
            $data = ['message' => 'Eliminato con successo!'];
        } else {
            $data = ['message' => 'Impossibile eliminare!'];
        }

        return response()->json($data);
    }

    public function updateUserRoles(Request $request) {

    }

    public function processProductBarcode(Request $request) {

    }
}
