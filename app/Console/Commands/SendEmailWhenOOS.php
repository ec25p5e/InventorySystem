<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendEmailWhenOOS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send_email_when_oos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invia una mail quando viene fatto il controllo dei prodotti out-of-stock';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        $this->info('Email inviate con successo!');
    }
}
