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

    public function duplicateProduct(Request $request) {
        $request->validate([
           'product_id' => 'required|int'
        ]);

        $product_id = $request->input('product_id');

        $productToDuplicate = Products::find($product_id);
        $productAttrs = ProductAttributes::where('product_ref_id', $product_id)
            ->where('attribute_hidden', 1)
            ->get();

        if($productToDuplicate) {
            $duplicatedRow = $productToDuplicate->replicate();
            $duplicatedRow->product_name = $duplicatedRow->product_name . ' - ProductCopied: ' . $product_id;
            $duplicatedRow->save();
            $newId = $duplicatedRow->id;
        }

        // Controlla se esiste il nuovo ID prodotto.
        // Se esiste clona tutti gli attributi copiabili
        if($newId != '0') {
            foreach ($productAttrs as $attribute) {
                $duplicatedAttribute = $attribute->replicate();
                $duplicatedAttribute->product_ref_id = $newId;
                $duplicatedAttribute->save();
            }
        }

        $data = ['message' => 'Prodotto duplicato con successo!'];
        return response()->json($data);
    }

    public function updateUserRoles(Request $request) {

    }

    public function processProductBarcode(Request $request) {

    }
}
