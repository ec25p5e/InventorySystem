<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportProductAttributes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import_history_access';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa i prodotti dalla tabella import_history_access';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userRefId = 755;
        $qtyCode = 'QTY';

        /**
         * STEP 1: Ciclare tutti i prodotti della tabella ponte
         *         per inserirli tutti negli attributi
         */

        $importHistory = DB::table('import_history_access as ihc')
            ->join('products as p', DB::raw("trim(substring_index(ihc.materiale, '-', -1))"), '=', 'p.product_name')
            ->select('ihc.materiale', 'ihc.quantita', 'p.id', 'ihc.data')
            ->where('materiale', 'C52 - Classatori 7cm rossi')
            ->orderBy('data', 'desc')
            ->get();

        foreach ($importHistory as $record) {
            // Esegui l'inserimento utilizzando il Query Builder
            DB::table('product_attributes')->insert([
                'attribute_code' => $qtyCode,
                'attribute_name' => 'Quantità',
                'attribute_value' => $record->quantita,
                'attribute_hidden' => 1,
                'attribute_unique' => 0,
                'attribute_log' => ' ',
                'attribute_log_detail' => 'CREATE BY SCRIPT import_stock_access()',
                'attribute_date_start' => $record->data,
                'attribute_date_end' => now(),
                'product_ref_id' => $record->id,
                'user_id' => $userRefId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        /**
         * STEP 2: Ciclare tutti i record per distinct per avere solo i nomi dei prodotti
         *         singoli. Dopodiché si ciclano e si aggiornano le date di fine dei record vecchi
         *         Dopo aver impostato le date di fine, imposta a null quella del record più recente
         */
         $distinctMaterials = DB::table('import_history_access')
             ->selectRaw('DISTINCT TRIM(SUBSTRING_INDEX(materiale, "-", -1)) AS material, data as data')
             ->whereNotNull('materiale')
             ->where('materiale', '=', 'C52 - Classatori 7cm rossi')
             ->get();


         // Cicla per cercare gli attributi qta di tutti
         foreach($distinctMaterials as $mat) {
             $attribute = DB::table('products as p')
                 ->join('product_attributes as pa', 'pa.product_ref_id', '=', 'p.id')
                 ->select('pa.*')
                 ->where('p.product_name', $mat->material)
                 ->where('pa.attribute_code', $qtyCode)
                 ->orderByDesc('pa.attribute_date_start')
                 ->first();

             // Aggiorna la data di fine a null per quello più recente
             DB::table('product_attributes')
                 ->where('id', $attribute->id)
                 ->update(['attribute_date_end' => null]);
         }

         $this->info('Importazione completata con successo.');
         return 0;
    }
}
