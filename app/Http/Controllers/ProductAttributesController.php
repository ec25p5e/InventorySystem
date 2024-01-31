<?php

namespace App\Http\Controllers;

use App\Models\ProductAttributes;
use App\Models\ProductAttributesDef;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductAttributesController extends Controller
{
    public function showHistory($product_id, $product_attr_id) {
        $attributeName = ProductAttributes::find($product_attr_id);
        $productAttributes = ProductAttributes::
        where(function ($query) use ($attributeName, $product_id) {
            $query->where('product_ref_id', '=', $product_id)
                ->where('attribute_code', '=', $attributeName->attribute_code);
        })
            ->orderBy('attribute_date_end', 'asc')
            ->get();


        return view('products.showHistory', [
            'attributeDetails' => $productAttributes,
            'attributeName' => $attributeName
        ]);
    }

    public function storeAttribute(Request $request)
    {
        $request->validate([
            'attribute_code' => 'required|string',
            'attribute_value' => 'required|string',
            'attribute_hidden' => 'required|int',
            'productId' => 'required|int'
        ]);

        $attributeCode = $request->input('attribute_code');
        $attributeValue = $request->input('attribute_value');
        $attributeHidden = $request->input('attribute_hidden');
        $productId = $request->input('productId');

        $getCodeName = ProductAttributesDef::find($attributeCode);
        $attributeCodeReal = $getCodeName->def_code;
        $log = '';

        $existingAttribute = ProductAttributes
            ::where('attribute_code', $attributeCodeReal)
            ->where('product_ref_id', $productId)
            ->whereNull('attribute_date_end')
            ->first();

        if($existingAttribute) {
            $productAttrId = $existingAttribute->id;
            $existingAttribute = ProductAttributes::find($productAttrId);

            if($existingAttribute->attribute_value < $attributeValue) {
                $log = 'INCREMENT';
            } else if($existingAttribute->attribute_value > $attributeValue) {
                $log = 'DECREMENT';
            }

            $attributeDataOld = [
                'attribute_code' => $existingAttribute->attribute_code,
                'attribute_name' => $existingAttribute->attribute_name,
                'attribute_value' => $existingAttribute->attribute_value,
                'attribute_hidden' => $existingAttribute->attribute_hidden,
                'attribute_unique' => $existingAttribute->attribute_unique,
                'attribute_log' => $existingAttribute->attribute_log,
                'product_ref_id' => $existingAttribute->product_ref_id,
                'attribute_date_start' => $existingAttribute->attribute_date_start,
                'attribute_date_end' => now(),
                'user_id' => Auth::id(),
            ];

            $existingAttribute->fill($attributeDataOld);
            $existingAttribute->save();
        }

        $attributeData = [
            'attribute_code' => $attributeCodeReal,
            'attribute_name' => $getCodeName->def_name,
            'attribute_value' => $attributeValue,
            'attribute_hidden' => $attributeHidden,
            'attribute_unique' => ($attributeCode == 'UNITY') ? 1 : 0,
            'product_ref_id' => $productId,
            'attribute_log' =>  $log,
            'attribute_date_start' => now(),
            'attribute_date_end' => null,
            'user_id' => Auth::id(),
        ];

        $product = ProductAttributes::create($attributeData);
        $message = 'Attributo creato con successo';

        Session::flash('success-product-attribute', $message);
        return back()->with('success', 'Operazione completata con successo.');
    }
}
