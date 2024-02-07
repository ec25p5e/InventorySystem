<?php

namespace App\Console\Commands;

use App\Models\Logs;
use App\Models\ProductAttributes;
use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class get_product_qty extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'variables:get_product_qty {product_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ritorna la quantità del prodotto alla data corrente';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Request $request)
    {
        $productId = $this->argument('product_id');

        $quantity = ProductAttributes::where('product_ref_id', $productId)
            ->where('attribute_code', getAttributeIdByCode('QTY'))
            ->whereNull('attribute_date_end')
            ->first();

        Logs::create([
            'log_type' => 'LOG_EXECUTION_OF_VARIABLE:' . $this->signature . '_' . $productId,
            'method' => $request->method(),
            'uri' => $request->url(),
            'message' => $quantity->attribute_value,
            'user_id' => Auth::id() ?? 0,
            'app_mode' => env('APP_ENV')
        ]);

        $this->info($quantity->attribute_value);
        return self::SUCCESS;
    }
}
