<?php

namespace App\Console\Commands;

use App\Services\CustomerImporterService;
use App\Services\DataImporterService;
use Illuminate\Console\Command;

class CustomerImporter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:customer-importer';

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
        (new DataImporterService)->import();
    }
}
