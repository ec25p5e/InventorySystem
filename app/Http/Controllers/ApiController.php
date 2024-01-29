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
            'product_attribute_id' => 'required|int',
            'product_id' => 'required|int'
        ]);

        $productAttrId = $request->input('product_attribute_id');
        $productId = $request->input('product_id');

        $attributeToDelete = ProductAttributes::find($productAttrId);

        if($attributeToDelete) {
            // Dopo l'eliminazione si deve rimettere il vecchio record come attuale (rimuovere attribute_date_end)
            $productAttribute = ProductAttributes::where('product_ref_id', $productId)
                ->where('attribute_code', $attributeToDelete->attribute_code)
                ->orderByDesc('attribute_date_end')
                ->first();

            $attributeToDelete->delete();
            $productAttribute->attribute_date_end = null;
            $productAttribute->save();
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
