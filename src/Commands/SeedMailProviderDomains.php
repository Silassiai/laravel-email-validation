<?php

namespace Silassiai\LaravelEmailValidation\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Silassiai\LaravelEmailValidation\Validation\EmailValidation;

class SeedMailProviderDomains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'silassiai:migrate-seed';

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
        Artisan::call('migrate --path=vendor/silassiai/laravel-email-validation/database/migrations/2022_08_02_101130_create_mail_provider_domains_table.php');

        $domainsThatShouldBeCheckedOnTypo = [
            ['domain' => 'hotmail.com', 'check_typo' => true,],
            ['domain' => 'hotmail.nl', 'check_typo' => true,],
            ['domain' => 'gmail.com', 'check_typo' => true,],
            ['domain' => 'gmail.nl', 'check_typo' => true,],
            ['domain' => 'yahoo.com', 'check_typo' => true,],
            ['domain' => 'ziggo.nl', 'check_typo' => true,],
            ['domain' => 'hetnet.nl', 'check_typo' => true,],
            ['domain' => 'upcmail.nl', 'check_typo' => true,],
            ['domain' => 'versatel.nl', 'check_typo' => true,],
            ['domain' => 'zonnet.nl', 'check_typo' => true,],
            ['domain' => 'kpnmail.nl', 'check_typo' => true,],
            ['domain' => 'planet.nl', 'check_typo' => true,],
            ['domain' => 'vodafone.nl', 'check_typo' => true,],
            ['domain' => 'outlook.nl', 'check_typo' => true,],
            ['domain' => 'outlook.com', 'check_typo' => true,],
            ['domain' => 'telenet.be', 'check_typo' => true,],
            ['domain' => 'tiscali.nl', 'check_typo' => true,],
            ['domain' => 'telfort.nl', 'check_typo' => true,],
            ['domain' => 'online.nl', 'check_typo' => true,],
            ['domain' => 'scarlet.nl', 'check_typo' => true,],
            ['domain' => 'zeelandnet.nl', 'check_typo' => true,],
            ['domain' => 'hotmail.no', 'check_typo' => true,],
            ['domain' => 'skynet.be', 'check_typo' => true,],
        ];

        $domainsThatShouldNotBeCheckedOnTypo = [
            ['domain' => 'hilton.com', 'check_typo' => false],
            ['domain' => 'yopmail.com', 'check_typo' => false],
            ['domain' => 'mailbox.org', 'check_typo' => false],
            ['domain' => 'onsmail.nl', 'check_typo' => false],
            ['domain' => 'hotmail.con', 'check_typo' => false],
            ['domain' => 'hotmail.co', 'check_typo' => false],
            ['domain' => 'hotmail.vom', 'check_typo' => false],
            ['domain' => 'hotmail.cm', 'check_typo' => false],
            ['domain' => 'mail.com', 'check_typo' => false],
            ['domain' => 'ymail.com', 'check_typo' => false],
            ['domain' => 'email.com', 'check_typo' => false],
            ['domain' => 'mail.bg', 'check_typo' => false],
            ['domain' => 'mail.nl', 'check_typo' => false],
            ['domain' => 'ymail.nl', 'check_typo' => false],
            ['domain' => 'gmail.con', 'check_typo' => false],
            ['domain' => 'gmail.co', 'check_typo' => false],
            ['domain' => 'gmail.vom', 'check_typo' => false],
            ['domain' => 'gmail.cm', 'check_typo' => false],
            ['domain' => 'yahoo.ie', 'check_typo' => false],
            ['domain' => 'yahoo.in', 'check_typo' => false],
            ['domain' => 'yahoo.ro', 'check_typo' => false],
            ['domain' => 'kpnmail.nl', 'check_typo' => false],
            ['domain' => 'onsnet.nu', 'check_typo' => false],
            ['domain' => 'upcmail.nl', 'check_typo' => false],
            ['domain' => 'scarlet.nl', 'check_typo' => false],
            ['domain' => 'kickmail.nl', 'check_typo' => false],
            ['domain' => 'tudelft.nl', 'check_typo' => false],
            ['domain' => 'tovert.nl', 'check_typo' => false],
            ['domain' => 'versatel.nl', 'check_typo' => false],
            ['domain' => 'tiscali.nl', 'check_typo' => false],
            ['domain' => 'meandernet.nl', 'check_typo' => false],
            ['domain' => 'meerlanden.nl', 'check_typo' => false],
        ];

        DB::table('mail_provider_domains')->truncate();

        if (DB::table('mail_provider_domains')->insert(
            array_merge($domainsThatShouldBeCheckedOnTypo, $domainsThatShouldNotBeCheckedOnTypo))
        ) {
            DB::table('mail_provider_domains')->orderBy('id')->chunk(500, function ($rows) {
                foreach ($rows as $row) {
                    Cache::forever(
                        ($row->check_typo
                            ? EmailValidation::SHOULD_CHECK_ON_TYPO_PREFIX
                            : EmailValidation::SHOULD_NOT_CHECK_ON_TYPO_PREFIX
                        ) . $row->domain,
                        $row->check_typo
                    );
                }
            });
            $this->info('Created table mail_provider_domains and seede successful!');
        } else {
            $this->error('Something went wrong!');
        }

        return 0;
    }
}
