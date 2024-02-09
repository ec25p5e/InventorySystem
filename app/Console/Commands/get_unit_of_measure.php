<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class get_unit_of_measure extends Command
{
    protected $signature = 'command:name';
    protected $description = 'Command description';

    public function handle()
    {
        return Command::SUCCESS;
    }
}
