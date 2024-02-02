<?php

namespace App\Console\Commands;

use App\Models\Logs;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import_products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa tutti i prodotti della tabella ponte, chiamata import_products';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Request $request)
    {
        DB::table('product_attributes')->delete();
        DB::table('products')->delete();


        /**
         * STEP 1: Elimina tutte le eventuali righe vuote
         */
        DB::table('import_products')->whereNull('name')->delete();


        /**
         * STEP 2: Ciclare tutti i dati della tabella e iniziare ad inserirli nella tabella products
         *         Infine riportare il nuovo ID nella tabella ponte per sapere a quali prodotti vanno
         *         legati gli attributi
         */
        $allProducts = DB::table('import_products')->get();

        if($allProducts->count() > 0) {
            $utilColumn = DB::table('import_products')
                ->select('spai as product_num_intern', 'ceap as product_num_ceap', 'name as product_name', 'new_product_id', 'delete_end_stock')
                ->get();

            foreach($utilColumn as $product) {
                $productRow = [
                    'product_num_ceap' => $product->product_num_ceap,
                    'product_num_intern' => $product->product_num_intern,
                    'product_name' => $product->product_name,
                    'product_start' => now(),
                    'product_end' => ($product->delete_end_stock == 'si' || $product->delete_end_stock == 'Si')
                        ? now() : null,
                    'product_image' => null
                ];

                $result = Products::create($productRow);

                DB::table('import_products')
                    ->where('spai', $product->product_num_intern)
                    ->update(['new_product_id' => $result->id]);
            }
        } else {
            return self::FAILURE;
        }

        /**
         * STEP 3.0: Iniziare a inserire gli attributi uno per uno
         *         Primo attributo: "Imballaggio da ..."
         */
        DB::table('product_attributes')->insertUsing(
            ['attribute_code', 'attribute_name', 'attribute_value', 'attribute_hidden', 'attribute_unique', 'attribute_log', 'attribute_log_detail', 'attribute_date_start', 'attribute_date_end', 'product_ref_id', 'user_id', 'created_at', 'updated_at'],
            function ($query) {
                $query->select(DB::raw("'PACK_OF' as attribute_code, 'Imballaggio da...' as attribute_name, imballaggio_da as attribute_value, 1 as attribute_hidden, 0 as attribute_unique, 'CREATE' as attribute_log, ' ' as attribute_log_detail, now() as attribute_date_start, null as attribute_date_end, new_product_id as product_ref_id, 755 as user_id, now() as created_at, now() as updated_at"))
                    ->from('import_products');
            }
        );

        /**
         * STEP 3.1: Iniziare a inserire gli attributi uno per uno
         *         Secondo attributo: "Unità"
         */
        DB::table('product_attributes')->insertUsing(
            ['attribute_code', 'attribute_name', 'attribute_value', 'attribute_hidden', 'attribute_unique', 'attribute_log', 'attribute_log_detail', 'attribute_date_start', 'attribute_date_end', 'product_ref_id', 'user_id', 'created_at', 'updated_at'],
            function ($query) {
                $query->select(DB::raw("'UNIT' as attribute_code, 'Unità' as attribute_name, unita as attribute_value, 1 as attribute_hidden, 0 as attribute_unique, 'CREATE' as attribute_log, ' ' as attribute_log_detail, now() as attribute_date_start, null as attribute_date_end, new_product_id as product_ref_id, 755 as user_id, now() as created_at, now() as updated_at"))
                    ->from('import_products');
            }
        );

        /**
         * STEP 3.2: Iniziare a inserire gli attributi uno per uno
         *         Secondo attributo: "Stock"
         */
        DB::table('product_attributes')->insertUsing(
            ['attribute_code', 'attribute_name', 'attribute_value', 'attribute_hidden', 'attribute_unique', 'attribute_log', 'attribute_log_detail', 'attribute_date_start', 'attribute_date_end', 'product_ref_id', 'user_id', 'created_at', 'updated_at'],
            function ($query) {
                $query->select(DB::raw("'QTY' as attribute_code, 'Quantità' as attribute_name, stock as attribute_value, 1 as attribute_hidden, 0 as attribute_unique, 'CREATE' as attribute_log, ' ' as attribute_log_detail, now() as attribute_date_start, null as attribute_date_end, new_product_id as product_ref_id, 755 as user_id, now() as created_at, now() as updated_at"))
                    ->from('import_products');
            }
        );

        /**
         * STEP 3.3: Iniziare a inserire gli attributi uno per uno
         *         Secondo attributo: "Data controllo stock"
         */
        DB::table('product_attributes')->insertUsing(
            ['attribute_code', 'attribute_name', 'attribute_value', 'attribute_hidden', 'attribute_unique', 'attribute_log', 'attribute_log_detail', 'attribute_date_start', 'attribute_date_end', 'product_ref_id', 'user_id', 'created_at', 'updated_at'],
            function ($query) {
                $query->select(DB::raw("'DATE_CTRL_STOCK' as attribute_code, 'Data controllo stock' as attribute_name, data_ctrl_stock as attribute_value, 1 as attribute_hidden, 0 as attribute_unique, 'CREATE' as attribute_log, ' ' as attribute_log_detail, now() as attribute_date_start, null as attribute_date_end, new_product_id as product_ref_id, 755 as user_id, now() as created_at, now() as updated_at"))
                    ->from('import_products');
            }
        );

        /**
         * STEP 3.4: Iniziare a inserire gli attributi uno per uno
         *         Secondo attributo: "Eliminare quando terminato lo stock"
         */
        DB::table('product_attributes')->insertUsing(
            ['attribute_code', 'attribute_name', 'attribute_value', 'attribute_hidden', 'attribute_unique', 'attribute_log', 'attribute_log_detail', 'attribute_date_start', 'attribute_date_end', 'product_ref_id', 'user_id', 'created_at', 'updated_at'],
            function ($query) {
                $query->select(DB::raw("'DELETE_PRODUCT_END_OF_STOCK' as attribute_code, 'Eliminare articolo a fine stock' as attribute_name, delete_end_stock as attribute_value, 1 as attribute_hidden, 0 as attribute_unique, 'CREATE' as attribute_log, ' ' as attribute_log_detail, now() as attribute_date_start, null as attribute_date_end, new_product_id as product_ref_id, 755 as user_id, now() as created_at, now() as updated_at"))
                    ->from('import_products');
            }
        );

        /**
         * STEP 3.5: Iniziare a inserire gli attributi uno per uno
         *         Secondo attributo: "Quantità minima"
         */
        DB::table('product_attributes')->insertUsing(
            ['attribute_code', 'attribute_name', 'attribute_value', 'attribute_hidden', 'attribute_unique', 'attribute_log', 'attribute_log_detail', 'attribute_date_start', 'attribute_date_end', 'product_ref_id', 'user_id', 'created_at', 'updated_at'],
            function ($query) {
                $query->select(DB::raw("'MIN_QTY' as attribute_code, 'Quantità minima' as attribute_name, min_qta as attribute_value, 1 as attribute_hidden, 0 as attribute_unique, 'CREATE' as attribute_log, ' ' as attribute_log_detail, now() as attribute_date_start, null as attribute_date_end, new_product_id as product_ref_id, 755 as user_id, now() as created_at, now() as updated_at"))
                    ->from('import_products');
            }
        );

        /**
         * STEP 3.6: Iniziare a inserire gli attributi uno per uno
         *         Secondo attributo: "Osservazioni"
         */
        DB::table('product_attributes')->insertUsing(
            ['attribute_code', 'attribute_name', 'attribute_value', 'attribute_hidden', 'attribute_unique', 'attribute_log', 'attribute_log_detail', 'attribute_date_start', 'attribute_date_end', 'product_ref_id', 'user_id', 'created_at', 'updated_at'],
            function ($query) {
                $query->select(DB::raw("'OBSERVATIONS' as attribute_code, 'Osservazioni' as attribute_name, osservazioni as attribute_value, 1 as attribute_hidden, 0 as attribute_unique, 'CREATE' as attribute_log, ' ' as attribute_log_detail, now() as attribute_date_start, null as attribute_date_end, new_product_id as product_ref_id, 755 as user_id, now() as created_at, now() as updated_at"))
                    ->from('import_products');
            }
        );

        /**
         * STEP 4: Dopo aver importato i record nella tabella "import_products_stock"
         *         Ciclare tutti i record e iniziare a inserire quelli più recenti verso quelli meno recenti
         *         L'operazione viene eseguita prodotto per prodotto
         */


    }
}
