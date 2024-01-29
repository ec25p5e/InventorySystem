<?php

namespace App\Http\Controllers;

use App\Models\ProductAttributes;
use App\Models\Products;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{

    public function loadProductColInfo(Request $request) {
        $request->validate([
            'product_id' => 'required|int',
            'entity' => 'required|string',
            'product_attribute' => 'required|string'
        ]);

        $productId = $request->input('product_id');
        $entity = $request->input('entity');
        $product_attribute = $request->input('product_attribute');
        $data = [];

        switch($entity) {
            case 'product_attributes':
                $attributeValue = ProductAttributes::where('product_ref_id', $productId)
                    ->where('attribute_code', $product_attribute)
                    ->value('attribute_value');

                $data['value'] = $attributeValue;
                break;
        }

        return response()->json($data);
    }

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
