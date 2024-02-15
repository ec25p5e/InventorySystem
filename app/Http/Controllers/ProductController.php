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
        $productEnd = getSettings('DEFAULT_DATE_END');
        $attributeCode = getAttributeIdByCode('UNITY');

        if($showLess == 1) {
            $products = DB::table('oos_products as oosp')
                ->whereIn('oosp.unity', function ($query) use ($userId) {
                    $query->select('ut.unity_code')
                        ->from('unities_tree as ut')
                        ->where('ut.user_id', $userId)
                        ->whereIn('ut.unity_id', function ($query) use ($userId) {
                            $query->select('u.unity_id')
                                ->from('users as u')
                                ->where('u.id', $userId);
                        });
                })
                ->get();
        } else if($showTerminateProducts == 1) {
            $products = DB::table('expired_products as ep')
                ->whereIn('ep.unity', function ($query) use ($userId) {
                    $query->select('ut.unity_id')
                        ->from('unities_tree as ut')
                        ->where('ut.user_id', $userId)
                        ->whereIn('ut.unity_id', function ($query) use ($userId) {
                            $query->select('u.unity_id')
                                ->from('users as u')
                                ->where('u.id', $userId);
                        });
                })
                ->get();
        } else {
            $products = DB::table('products as p')
                ->join('product_attributes as pa', 'pa.product_ref_id', '=', 'p.id')
                ->where('pa.attribute_code', $attributeCode)
                ->where(function ($query) use ($productEnd) {
                    $query->whereNull('pa.attribute_date_end')
                        ->orWhere('pa.attribute_date_end', $productEnd);
                })
                ->whereIn('pa.attribute_value', function ($query) use ($userId) {
                    $query->select('ut.unity_id')
                        ->from('unities_tree as ut')
                        ->where('ut.user_id', $userId)
                        ->whereIn('ut.unity_id', function ($query) use ($userId) {
                            $query->select('u.unity_id')
                                ->from('users as u')
                                ->where('u.id', $userId);
                        });
                })
                ->select('p.*')
                ->get();
        }

        return view('products.index', [
            'products' => $products,
            'showLess' => $showLess,
            'showTerminateProducts' => $showTerminateProducts
        ]);
    }

    public function create()
    {
        $getDefinitionsOfProducts = ProductAttributesDef::where('is_visible', 1)->get();
        $unities = DB::table('unities_tree')
            ->where('user_id', Auth::id())
            ->get();

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
        $getDefinitionsOfProducts = ProductAttributesDef::where('is_visible', 1)->get();
        $unities = DB::table('unities_tree')
            ->where('user_id', Auth::id())
            ->get();

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
            'product_num_ceap' => 'int',
            'product_num_intern' => 'string',
            'product_name' => 'required|string|',
            'product_start' => [
                'required',
                'date'
            ],
            'product_end' => [
                'required',
                'date'
            ],
        ]);

        $productData = [
            'product_num_ceap' => $request->input('product_num_ceap'),
            'product_num_intern' => $request->input('product_num_intern'),
            'product_name' => $request->input('product_name'),
            'product_start' => $request->input('product_start'),
            'product_end' => ($request->input('product_end') == null) ? getSettings('DEFAULT_DATE_END') : $request->input('product_end'),
            'product_image' => null
        ];

        $productId = $request->input('productIdHidden');
        $product = Products::find($productId);

        if ($product) {
            $product->fill($productData);
            $product->save();

            $message = 'Articolo aggiornato con successo!';
        } else {
            $product = Products::create($productData);

            $attributeDataQty = [
                'attribute_code' => ProductAttributesDef::where('def_code', 'UNITY')->first()->id,
                'attribute_name' => ' ',
                'attribute_value' => $request->input('unity_ref'),
                'attribute_hidden' => 1,
                'attribute_unique' => 1,
                'attribute_log' => 'CREATE',
                'attribute_log_detail' => ' ',
                'attribute_date_start' => now(),
                'attribute_date_end' => null,
                'product_ref_id' => $product->id,
                'user_id' => Auth::id(),
                'user_mod' => Auth::id()
            ];

            ProductAttributes::create($attributeDataQty);
            $message = 'Articolo creato con successo! Il codice progressivo è: ' . $product->id;
        }
        Session::flash('success', $message);

        return redirect(getRouteUri(Auth::id(), 'LIST_OF_PRODUCTS'));
    }

    public function movements(Request $request)
    {
        $quantityCode = getAttributeIdByCode('QTY');
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

        $prodBarcodeRules = [
            'product_barcode' => 'required|int|min:0'
        ];

        $productCompleteRules = [
            'product_id' => 'required|int|min:0',
            'product_barcode' => 'required|int|min:0',
            'product_num_ceap' => 'required|int|min:0',
            'product_name' => 'required|string'
        ];

        $validatorIdRules = Validator::make($request->all(), $productIdRules);
        $validatorProdName = Validator::make($request->all(), $prodNameRules);
        $validatorNumCeap = Validator::make($request->all(), $numCeapRules);
        $validatorBarcode = Validator::make($request->all(), $prodBarcodeRules);
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

        if(!$validatorBarcode->fails()) {
            $key['product_barcode'] = $request->input('product_barcode');
        }

        if (!$validatorComplete->fails()) {
            $productId = $request->input('product_id');
            $key['product_num_ceap'] = $request->input('product_num_ceap');
        }

        if(isset($key['product_num_ceap'])) {
            $safeKey = $key['product_num_ceap'];
        } else if(isset($key['product_name'])) {
            $safeKey = $key['product_name'];
        } else if(isset($key['product_barcode'])) {
            $safeKey = $key['product_barcode'];
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
                ->where('pa.attribute_code', getAttributeIdByCode('UNITY'))
                ->orWhere(function($query) use ($safeKey) {
                    $query = ProductAttributes::where('attribute_code', getAttributeIdByCode('BARCODE'))
                        ->whereNull('attribute_date_end')
                        ->where('attribute_value', $safeKey)
                        ->get();
                })
                ->whereIn('pa.attribute_value', function ($query) use ($userId) {
                    $query->select('ut.unity_id')
                        ->from('unities_tree as ut')
                        ->where('ut.user_id', $userId)
                        ->whereIn('ut.unity_id', function ($query) use ($userId) {
                            $query->select('u.unity_id')
                                ->from('users as u')
                                ->where('u.id', $userId);
                        });
                })
                ->select("p.*")
                ->get();


            $dates = ProductAttributes::selectRaw('cast(attribute_date_start AS DATE) AS attribute_date')
                ->where('attribute_code', $quantityCode)
                ->where('product_ref_id', $productId)
                ->groupByRaw('CAST(attribute_date_start AS DATE)')
                ->orderByRaw('CAST(attribute_date_start AS DATE) desc')
                ->get();

            $movementForDate = function ($date) use ($productId, $quantityCode) {
                $productAttributes = ProductAttributes::where('attribute_code', $quantityCode)
                    ->where('product_ref_id', $productId)
                    ->where('attribute_date_start', 'like', $date . '%')
                    ->orderBy('attribute_date_start', 'desc')
                    ->get();

                return $productAttributes;
            };
        }

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

        // Controlla se esiste il nuovo ID Articolo.
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

    public function bulkMovements(Request $request) {
        $teachers = User::where('id', '!=', Auth::id())->get();
        $key['user_register'] = Auth::id();
        $key['type_of_movements'] = null;

        $settingsRules = [
            '_token' => 'required|string',
            'type_of_movements' => 'required|string',
            'user_register' => 'required|int|min:0'
        ];

        $settingsValidator = Validator::make($request->all(), $settingsRules);

        if(!$settingsValidator->fails()) {
            $key['type_of_movements'] = $request->input('type_of_movements');
            $key['user_register'] = $request->input('user_register');
            $teachers = User::where('id', '!=', $key['user_register'])->get();
        }

        return view('products.bulkMovements', [
            'users_register' => $teachers,
            'key' => $key
        ]);
    }
}
