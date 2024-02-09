<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Test extends Command
{
    protected $signature = 'my-command {arg1} {arg2}';

    public function handle()
    {
        $arg1Value = $this->argument('arg1');
        $arg2Value = $this->argument('arg2');

        // Fai qualcosa con gli argomenti
        $this->info('Argomento 1: ' . $arg1Value);
        $this->info('Argomento 2: ' . $arg2Value);
    }
}
