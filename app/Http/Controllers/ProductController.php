<?php

namespace App\Http\Controllers;

use App\Helpers\SettingsHelper;
use App\Models\ProductAttributes;
use App\Models\ProductAttributesDef;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{

    // Visualizzazione di tutti i prodotti
    public function index(Request $request) {
        $products = Products::all();

        return view('products.index', [
            'products' => $products
        ]);
    }

    public function create()
    {
        $getDefinitionsOfProducts = ProductAttributesDef::all();
        return view('products.create', ['attributeDefinitions' => $getDefinitionsOfProducts]);
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

        return view('products.create', [
            'productDetails' => $productDetails,
            'productAttributes' => $getProductAttr,
            'attributeDefinitions' => $getDefinitionsOfProducts,
            'product_id' => $product_id
        ]);
    }

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

    public function store(Request $request) {
        $request->validate([
            'product_num_ceap' => 'required|int|',
            'product_num_intern' => 'required|string|',
            'product_name' => 'required|string|',
            'product_start' => [
                'required',
                'date'
            ],
        ]);

        $getDefinitionsOfProducts = ProductAttributesDef::all();
        $product = new Products;
        $product->product_num_ceap = $request->input('product_num_ceap');
        $product->product_num_intern = $request->input('product_num_intern');
        $product->product_name = $request->input('product_name');
        $product->product_start = $request->input('product_start');
        $product->product_end = $request->input('product_end');
        $product->product_image = null;
        $product->save();

        Session::flash('success', 'Prodotto creato con successo!');
        return view('products.create', [
            'productDetails' => $product,
            'attributeDefinitions' => $getDefinitionsOfProducts
        ]);
    }

    public function movements() {
        return view('products.movements');
    }
}
