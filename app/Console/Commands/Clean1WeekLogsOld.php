<?php

namespace App\Console\Commands;

use App\Models\Notifications;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Clean1WeekLogsOld extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:clean_1_week_logs_old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all 1 week old logs';


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $oneWeeksAgo = Carbon::now()->subWeek();
        $count = DB::table('logs')
            ->whereDate('created_at', '<', $oneWeeksAgo)
            ->count();

        do {
            $deleteProcedure = DB::select('CALL clear_1_weeks_access_log()');
            Notifications::create([
                'notification_code' => 'AUTO_CLEAN_1_WEEKS_AGO_ACCESS_LOG',
                'notification_title' => 'Pulizia logs',
                'notification_message' => 'Sono stati puliti i log di accesso correttamente. Sono state rimosse ' . $deleteProcedure[0]->countLogs . ' righe',
                'notification_uri' => '/',
                'notification_args' => '/',
                'user_id_ref' => 1,
                'is_checked' => 0
            ]);
        } while($count > 0);
    }
}
