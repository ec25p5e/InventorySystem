<?php

namespace App\Console\Commands;

use App\Models\Logs;
use App\Models\ProductAttributes;
use App\Models\Unities;
use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use function MongoDB\BSON\toJSON;

class get_school_ref_for_product extends Command
{
    protected $signature = 'variables:get_school_ref_for_product {product_id}';
    protected $description = 'Command description';

    public function handle(Request $request)
    {
        $arguments = $this->argument('product_id');

        $quantity = ProductAttributes::where('product_ref_id', $arguments)
            ->where('attribute_code', getAttributeIdByCode('UNITY'))
            ->whereNull('attribute_date_end')
            ->first();

        Logs::create([
            'log_type' => 'LOG_EXECUTION_OF_VARIABLE:' . $this->signature . '_' . $arguments,
            'method' => $request->method(),
            'uri' => $request->url(),
            'message' => $quantity,
            'user_id' => Auth::id() ?? 0,
            'app_mode' => env('APP_ENV')
        ]);

        if($quantity->attribute_value === null) {
            return self::FAILURE;
        } else {
            $this->line(getUnityCode($quantity->attribute_value));
            return self::SUCCESS;
        }
    }
}
