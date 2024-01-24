<?php

namespace App\Http\Controllers;

use App\Models\ProductAttributesDef;
use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    // Visualizzazione di tutti i prodotti
    public function index(Request $request) {
        $filters = array();
        $filters[0] = $request->input('filter__product_num_ceap');
        $filters[1] = $request->input('filter__product_num_intern');
        $filters[2] = $request->input('filter__product_name');

        $products = Products::when($filters[0], function($query) use ($filters) {
            return $query->where('product_num_ceap', 'like', '%' . $filters[0] . '%');
        })->when($filters[1], function ($query) use ($filters) {
            return $query->where('product_num_intern', 'like', '%' . $filters[1] . '%');
        })->when($filters[2], function ($query) use ($filters) {
            return $query->where('product_name', 'like', '%' . $filters[2] . '%');
        })-> get();

        return view('products.index', [
            'products' => $products,
            'filters' => $filters
        ]);
    }

    // Aggiungi un nuovo prodotto
    public function create() {
        $getDefinitionsOfProducts = ProductAttributesDef::all();
        return view('products.create', [
            'attributeDefinitions' => $getDefinitionsOfProducts
        ]);
    }

    // Metodo per gestire l'inserimento di un nuovo prodotto
    public function store(Request $request) {
        /* $request->validate([
            'product_num_ceap' => 'required|int|max:20',
            'product_num_intern' => 'required|string|max:20',
            'product_name' => 'required|string|max:255',
            'product_start' => [
                'required',
                'date'
            ],
        ]); */

        $product = new Products;
        $product->product_num_ceap = $request->input('product_num_ceap');
        $product->product_num_intern = $request->input('product_num_intern');
        $product->product_name = $request->input('product_name');
        $product->product_start = $request->input('product_start');
        $product->product_end = $request->input('product_end');
        $product->product_image = null;
        $product->save();

        Session::flash('success', 'Prodotto creato con successo!');


        return redirect()->route('products.create');
    }
}
