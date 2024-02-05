<?php

namespace App\Http\Controllers;

use App\Models\ProductAttributes;
use App\Models\ProductAttributesDef;
use App\Models\Products;
use App\Models\Unities;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function index(Request $request) {
        $showLess = $request->input('showLess');
        $showTerminateProducts = $request->input('showTerminateProducts');
        $userId = Auth::id();

        if($showLess == 1) {
            $products = DB::table('oos_products as oosp')
                ->whereIn('oosp.unity', function ($query) use ($userId) {
                    $query->select('ut.unity_code')
                        ->from('unities_tree as ut')
                        ->where('ut.user_id', $userId)
                        ->whereExists(function ($query) {
                            $query->select('u.unity_id')
                                ->from('users as u')
                                ->whereColumn('u.id', 'ut.user_id');
                        });
                })
                ->paginate(getSettings('MAX_ROW_PER_PAR'));
        } else if($showTerminateProducts == 1) {
            $products = DB::table('expired_products as ep')
                ->whereIn('ep.unity', function ($query) use ($userId) {
                    $query->select('ut.unity_code')
                        ->from('unities_tree as ut')
                        ->where('ut.user_id', $userId)
                        ->whereExists(function ($query) {
                            $query->select('u.unity_id')
                                ->from('users as u')
                                ->whereColumn('u.id', 'ut.user_id');
                        });
                })
                ->paginate(getSettings('MAX_ROW_PER_PAR'));
        } else {
            $products = DB::table('products as p')
                ->join('product_attributes as pa', 'pa.product_ref_id', '=', 'p.id')
                ->where('pa.attribute_code', 'UNITY')
                ->whereNull('p.product_end')
                ->whereNull('pa.attribute_date_end')
                ->whereIn('pa.attribute_value', function ($query) use ($userId) {
                    $query->select('ut.unity_code')
                        ->from('unities_tree as ut')
                        ->where('ut.user_id', $userId)
                        ->whereExists(function ($query) {
                            $query->select('u.unity_id')
                                ->from('users as u')
                                ->whereColumn('u.id', 'ut.user_id');
                        });
                })
                ->select('p.*')
                ->paginate(getSettings('MAX_ROW_PER_PAR'));
        }

        return view('products.index', [
            'products' => $products,
            'showLess' => $showLess,
            'showTerminateProducts' => $showTerminateProducts
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

    public function movements(Request $request)
    {
        $quantityCode = 'QTY';
        $userId = Auth::id();
        $productId = null;
        $key[] = null;
        $dates = null;
        $movementForDate = null;
        $listOfProducts = null;

        $productIdRules = [
            'product_id' => 'required|int|min:0'
        ];

        $numCeapRules = [
            'product_num_ceap' => 'required|int|min:0'
        ];

        $prodNameRules = [
            'product_name' => 'required|string'
        ];

        $productCompleteRules = [
            'product_id' => 'required|int|min:0',
            'product_num_ceap' => 'required|int|min:0',
            'product_name' => 'required|string'
        ];

        $validatorIdRules = Validator::make($request->all(), $productIdRules);
        $validatorProdName = Validator::make($request->all(), $prodNameRules);
        $validatorNumCeap = Validator::make($request->all(), $numCeapRules);
        $validatorComplete = Validator::make($request->all(), $productCompleteRules);

        if (!$validatorIdRules->fails()) {
            $productId = $request->input('product_id');
        }

        if (!$validatorNumCeap->fails()) {
            $key['product_num_ceap'] = $request->input('product_num_ceap');
        }

        if (!$validatorProdName->fails()) {
            $key['product_name'] = $request->input('product_name');
        }

        if (!$validatorComplete->fails()) {
            $productId = $request->input('product_id');
            $key['product_num_ceap'] = $request->input('product_num_ceap');
        }

        if(isset($key['product_num_ceap'])) {
            $safeKey = $key['product_num_ceap'];
        } else if(isset($key['product_name'])) {
            $safeKey = $key['product_name'];
        } else {
            $safeKey = null;
        }

        if(isset($safeKey)) {
            $listOfProducts = DB::table('products as p')
                ->join('product_attributes as pa', 'pa.product_ref_id', '=', 'p.id')
                ->where(function($query) use ($safeKey, $productId) {
                    $query->where('p.id', $productId)
                        ->orWhere('p.product_num_ceap', $safeKey)
                        ->orWhere('p.product_name', 'LIKE', $safeKey . '%')
                        ->orWhere('p.product_num_intern', 'LIKE', '%' . $safeKey . '%');
                })
                ->whereNull('pa.attribute_date_end')
                ->where('pa.attribute_code', 'UNITY')
                ->whereIn('pa.attribute_value', function ($query) use ($userId) {
                    $query->select('ut.unity_code')
                        ->from('unities_tree as ut')
                        ->where('ut.user_id', $userId);
                })
                ->select("p.*")
                ->paginate(getSettings('PAGINATE_TABLE_PRODUCTS_IN_MOVEMENTS'));


            $dates = ProductAttributes::selectRaw('cast(attribute_date_start AS DATE) AS attribute_date')
                ->where('attribute_code', $quantityCode)
                ->where('product_ref_id', $productId)
                ->groupByRaw('CAST(attribute_date_start AS DATE)')
                ->orderByRaw('CAST(attribute_date_start AS DATE) desc')
                ->get();

            $movementForDate = function ($date) use ($productId, $quantityCode) {
                $productAttributes = ProductAttributes::where('attribute_code', 'QTY')
                    ->where('product_ref_id', $productId)
                    ->where('attribute_date_start', 'like', $date . '%')
                    ->orderBy('attribute_date_start', 'desc')
                    ->get();

                return $productAttributes;
            };
        }

        // Prendi tutti gli utenti non sull'unità Root
        // Quindi sono amministrativi o docenti
        $teachers = User::all();


        return view('products.movements', [
            'timelineDates' => $dates,
            'moveForDate' => $movementForDate,
            'listOfProducts' => $listOfProducts,
            'productId' => $productId,
            'formFields' => $key,
            'teachers' => $teachers
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
