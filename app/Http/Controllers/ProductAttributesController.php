<?php

namespace App\Http\Controllers;

use App\Models\ProductAttributes;
use App\Models\ProductAttributesDef;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductAttributesController extends Controller
{
    public function showHistory($product_id, $product_attr_id) {
        $attributeName = ProductAttributes::find($product_attr_id);
        $productAttributes = ProductAttributes::
        where(function ($query) use ($attributeName, $product_id) {
            $query->where('product_ref_id', '=', $product_id)
                ->where('attribute_code', '=', $attributeName->attribute_code);
        })
            ->orderBy('attribute_date_start', 'desc')
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
        $log = '';

        $existingAttribute = ProductAttributes
            ::where('attribute_code', $attributeCode)
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
                'attribute_log_detail' => $attributeValue,
                'product_ref_id' => $existingAttribute->product_ref_id,
                'attribute_date_start' => $existingAttribute->attribute_date_start,
                'attribute_date_end' => now(),
                'user_id' => Auth::id(),
            ];

            $existingAttribute->fill($attributeDataOld);
            $existingAttribute->save();
        }

        $attributeData = [
            'attribute_code' => $attributeCode,
            'attribute_name' => ' ',
            'attribute_value' => $attributeValue,
            'attribute_hidden' => $attributeHidden,
            'attribute_unique' => ($attributeCode == 'UNITY') ? 1 : 0,
            'product_ref_id' => $productId,
            'attribute_log' =>  $log,
            'attribute_log_detail' => ' ' . $attributeValue . ' ',
            'attribute_date_start' => now(),
            'attribute_date_end' => null,
            'user_id' => Auth::id(),
        ];

        $product = ProductAttributes::create($attributeData);
        $message = 'Attributo creato con successo';

        Session::flash('success-product-attribute', $message);
        return back()->with('success', 'Operazione completata con successo.');
    }

    public function editAttribute(Request $request) {
        $validationRules = [
            'attribute_code' => 'required|string',
            'product_ref_id' => 'required|numeric|min:0',
            'attribute_log' => 'required|string',
            'attribute_value' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if(!$validator->fails()) {
            $attributeCode = $request->input('attribute_code');
            $productId = $request->input('product_ref_id');
            $attributeLog = $request->input('attribute_log');
            $attributeValue = $request->input('attribute_value');
            $attributeDateStart = now();
            $userId = $request->input('user_id');

            // Verifica il codice dell'attributo
            if($attributeCode != 'QTY') {
                exit;
            }

            if(isset($productId)) {
                // Prendi la riga attuale
                $currentRow = ProductAttributes::where('product_ref_id', $productId)
                    ->where('attribute_code', getAttributeIdByCode($attributeCode))
                    ->whereNull('attribute_date_end')
                    ->first();

                $isHidden = $currentRow->attribute_hidden;
                $isUnique = $currentRow->attribute_unique;
                $rowValue = $currentRow->attribute_value;

                if ($attributeLog == 'INCREMENT') {
                    $rowValue += $attributeValue;
                } else if ($attributeLog == 'DECREMENT') {
                    $rowValue -= $attributeValue;
                }

                if($rowValue < 0) {
                    $rowValue = 0;
                }

                // Imposta la data di fine della riga corrente
                $currentRow->attribute_date_end = now();
                $currentRow->save();

                // Inserisci la nuova riga
                $newRow = [
                    'attribute_code' => getAttributeIdByCode($attributeCode),
                    'attribute_name' => ' ',
                    'attribute_value' => $rowValue,
                    'attribute_hidden' => $isHidden,
                    'attribute_unique' => $isUnique,
                    'product_ref_id' => $productId,
                    'attribute_log' =>  $attributeLog,
                    'attribute_log_detail' => $attributeValue,
                    'attribute_date_start' => $attributeDateStart,
                    'attribute_date_end' => null,
                    'user_id' => isset($userId) > 0 ? $userId : Auth::id(),
                    'user_mod' => Auth::id()
                ];

                ProductAttributes::create($newRow);
            }

            return back()->with('success-edit-attribute', 'Quantità registrata con successo!');
        }
    }
}
