<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use File;

class MonthendCloseRoutineCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:monthend-close-routine-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $log = '[' . date('Y-m-d H:i:s') . '] Fechamento de mês '. PHP_EOL;
        File::append(
            storage_path('logs/schedule.log'),
            $log
        );

        \App\Models\Extension::tiggerMonthendClose();

    }
}
