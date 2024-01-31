<?php

namespace App\Jobs;

use App\Models\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CheckProductOOS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Controlla se ci sono righe nella vista
        $count = DB::table('internal_product_warning')->count();

        if($count > 0) {
            // Se ci sono righe, inserire nel DB
            Notifications::create([
                'notification_code' => 'AUTO_GENERATED_OOS',
                'notification_title' => 'Prodotti in esaurimento',
                'notification_message' => 'Gli stock di alcuni prodotti sono in esaurimento',
                'user_id_ref' => 1,
                'is_checked' => 0
            ]);
        }
    }
}
