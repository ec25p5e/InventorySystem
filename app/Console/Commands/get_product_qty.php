<?php

namespace App\Console\Commands;

use App\Models\Logs;
use App\Models\ProductAttributes;
use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class get_product_qty extends Command
{
    protected $signature = 'variables:get_product_qty {product_id}';
    protected $description = 'Ritorna la quantità del prodotto alla data corrente';

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
            'message' => $quantity,
            'user_id' => Auth::id() ?? 0,
            'app_mode' => env('APP_ENV')
        ]);

        if($quantity === null) {
            return self::FAILURE;
        } else {
            $this->info($quantity->attribute_value);
            return self::SUCCESS;
        }
    }
}
