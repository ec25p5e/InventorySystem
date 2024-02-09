<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportProductStocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import_product_stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa i prodotti dalla tabella import_product_stock';

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
         * STEP 1: Ciclare tutti i materiali per distinct. I record sono dell'entità: import_product_stock
         */
        $materials = DB::table('import_product_stock as ips')
            ->select(DB::raw("DISTINCT SUBSTRING_INDEX(ips.materiale, ' - ', 1) as material"))
            ->where('materiale', 'C52 - Classatori 7cm rossi')
            ->get();

        foreach($materials as $material) {
            print_r($material);
        }
    }
}
