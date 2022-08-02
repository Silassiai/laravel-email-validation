<?php

namespace Silassiai\LaravelEmailValidation\Commands;

use Illuminate\Console\Command;

class SeedMailProviderDomains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'silassiai:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds and caches mail provider domains';

    /**
     * Create a new command instance.
     *
     * @return void
     */
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
        
        return 0;
    }
}
