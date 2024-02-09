<?php

namespace App\Console\Commands;

use App\Models\Logs;
use App\Models\Products;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class get_product_date_end extends Command
{
    protected $signature = 'variables:get_product_date_end {product_id}';
    protected $description = 'Ritorna la data di fine del prodotto';

    public function handle(Request $request)
    {
        $productId = $this->argument('product_id');
        $row = Products::where('id', $productId)->first();
        $decoded = json_decode($row);

        Logs::create([
            'log_type' => 'LOG_EXECUTION_OF_VARIABLE:' . $this->signature . '_' . $productId,
            'method' => $request->method(),
            'uri' => $request->url(),
            'message' => $row,
            'user_id' => Auth::id() ?? 0,
            'app_mode' => env('APP_ENV')
        ]);

        $this->info(formatDateTime($decoded?->product_end));
        return self::SUCCESS;
    }
}
