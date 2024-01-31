<?php

namespace App\Http\Controllers;

use App\Helpers\SettingsHelper;
use App\Models\ProductAttributes;
use App\Models\ProductAttributesDef;
use App\Models\Products;
use App\Models\Unities;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{

    public function index(Request $request) {
        $showLess = $request->input('showLess');

        if($showLess == 1) {
            $count = DB::table('internal_product_warning')->count();
            if($count > 0) {
                $products = DB::table('internal_product_warning')->get();
            } else {
                $products = null;
            }
        } else {
            $products = Products::whereNull('product_end')->paginate(10);
        }


        return view('products.index', [
            'products' => $products,
            'showLess' => $showLess
        ]);
    }

    public function lessProducts() {
        $products = DB::table('internal_product_warning')->get();

        return view('products.lessProducts', [
            'products' => $products
        ]);
    }

    public function create()
    {
        $getDefinitionsOfProducts = ProductAttributesDef::all();
        $unities = Unities::all();

        return view('products.create', [
            'unities' => $unities,
            'attributeDefinitions' => $getDefinitionsOfProducts,
        ]);
    }


    public function update($product_id) {
        $productDetails = Products::find($product_id);
        $getProductAttr = ProductAttributes
            ::where(function ($query) use ($product_id) {
                $query->where('product_ref_id', '=', $product_id)
                    -> where('attribute_date_end', '=', null);
            })
            -> get();
        $getDefinitionsOfProducts = ProductAttributesDef::all();
        $unities = Unities::where('id', '!=', '1')->get();

        return view('products.create', [
            'productDetails' => $productDetails,
            'productAttributes' => $getProductAttr,
            'attributeDefinitions' => $getDefinitionsOfProducts,
            'product_id' => $product_id,
            'unities' => $unities
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'product_name' => 'required|string|',
            'product_start' => [
                'required',
                'date'
            ],
        ]);

        $productData = [
            'product_num_ceap' => $request->input('product_num_ceap'),
            'product_num_intern' => $request->input('product_num_intern'),
            'product_name' => $request->input('product_name'),
            'product_start' => $request->input('product_start'),
            'product_end' => ($request->input('product_end') == null) ? '01-01-3000 00:00:00' : $request->input('product_end'),
            'product_image' => null
        ];

        $productId = $request->input('productIdHidden');
        $product = Products::find($productId);

        if ($product) {
            $product->fill($productData);
            $product->save();
            $message = 'Prodotto aggiornato con successo!';
        } else {
            $product = Products::create($productData);
            $message = 'Prodotto creato con successo!';
        }

        $unities = Unities::all();
        Session::flash('success', $message);

        return view('products.create', [
            'productDetails' => $product,
            'unities' => $unities,
            'attributeDefinitions' => ProductAttributesDef::all()
        ]);
    }

    public function movements(Request $request) {
        $quantityCode = 'QTY';
        $request->validate([
           'product_id' => 'required|int'
        ]);
        $productId = $request->input('product_id');

        $dates = ProductAttributes::selectRaw('CAST(attribute_date_start AS DATE) AS attribute_date')
            ->where('attribute_code', $quantityCode)
            ->where('product_ref_id', $productId)
            ->groupByRaw('CAST(attribute_date_start AS DATE)')
            ->orderByRaw('CAST(attribute_date_start AS DATE) desc')
            ->get();

        $movementForDate = function($date) use ($quantityCode) {
            $productAttributes = ProductAttributes::where('attribute_code', 'QTY')
                ->where('product_ref_id', 285)
                ->where('attribute_date_start', 'like', $date . '%')
                ->get();

            return $productAttributes;
        };

        return view('products.movements', [
            'timelineDates' => $dates,
            'moveForDate' => $movementForDate
        ]);
    }

    public function movementsAdmin(Request $request) {
        $quantityCode = 'QTY';
        $request->validate([
            'product_id' => 'required|int'
        ]);
        $productId = $request->input('product_id');

        $dates = ProductAttributes::selectRaw('CAST(attribute_date_start AS DATE) AS attribute_date')
            ->where('attribute_code', $quantityCode)
            ->where('product_ref_id', $productId)
            ->groupByRaw('CAST(attribute_date_start AS DATE)')
            ->orderByRaw('CAST(attribute_date_start AS DATE) desc')
            ->get();

        $movementForDate = function($date) use ($quantityCode) {
            $productAttributes = ProductAttributes::where('attribute_code', 'QTY')
                ->where('product_ref_id', 285)
                ->where('attribute_date_start', 'like', $date . '%')
                ->get();

            return $productAttributes;
        };

        return view('products.movements', [
            'timelineDates' => $dates,
            'moveForDate' => $movementForDate
        ]);
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

        return view('products.update', ['product_id' => $product_id]);
    }
}
