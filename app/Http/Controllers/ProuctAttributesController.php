<?php

namespace App\Http\Controllers;

use App\Models\ProductAttributes;
use App\Models\ProductAttributesDef;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProuctAttributesController extends Controller
{
    public function storeAttribute(Request $request)
    {
        $request->validate([
            'attribute_code' => 'required|string',
            'attribute_value' => 'required|string',
            'attribute_hidden' => 'required'
        ]);

        $attributeCode = $request->input('attribute_code');
        $attributeValue = $request->input('attribute_value');
        $productId = $request->input('productId');

        $getCodeName = ProductAttributesDef::find($attributeCode);
        $attributeCodeReal = $getCodeName->def_code;

        $checkIfExists = ProductAttributes
            ::where(function ($query) use ($attributeCodeReal, $productId) {
                $query->where('attribute_code', '=', $attributeCodeReal)
                    ->where('product_ref_id', '=', $productId);
            })->first();

        if ($getCodeName->def_name != null && $checkIfExists == null) {
            if (Auth::check()) {
                $this->insertProductAttribute(
                    $getCodeName->def_code,
                    $getCodeName->def_name,
                    $attributeValue,
                    $request->input('attribute_hidden'),
                    $productId
                );
            }
        } else if (Auth::check() && $checkIfExists != null) {
            if($checkIfExists->attribute_value != $attributeValue) {
                $rowToUpdate = ProductAttributes::find($checkIfExists->id);
                $rowToUpdate->attribute_date_end = now();
                $rowToUpdate->save();

                $this->insertProductAttribute(
                    $getCodeName->def_code,
                    $getCodeName->def_name,
                    $attributeValue,
                    $request->input('attribute_hidden'),
                    $productId
                );
            }
        }

        Session::flash('success-product-attribute', 'Attributo registrato');
        return back()->with('success', 'Operazione completata con successo.');
    }


    private function insertProductAttribute(
        $defCode,
        $defName,
        $attributeValue,
        $attributeHidden,
        $productId
    ): void
    {
        $productAttribute = new ProductAttributes;
        $productAttribute->attribute_code = $defCode;
        $productAttribute->attribute_name = $defName;
        $productAttribute->attribute_value = $attributeValue;
        $productAttribute->attribute_hidden = $attributeHidden;
        $productAttribute->product_ref_id = $productId;
        $productAttribute->attribute_date_start = now();
        $productAttribute->attribute_date_end = null;
        $productAttribute->user_id = Auth::id();
        $productAttribute->save();
    }
}
