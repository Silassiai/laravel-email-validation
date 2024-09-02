<?php

namespace Silassiai\LaravelEmailValidation\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Silassiai\LaravelEmailValidation\Models\MailProviderDomain;

class SeedMailProviderDomains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'silassiai-email-validation:seed';

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
        if (!Schema::hasTable('mail_provider_domains')) {
            Artisan::call('migrate --path=vendor/silassiai/laravel-email-validation/database/migrations/2022_08_02_101130_create_mail_provider_domains_table.php');
            $this->info('Created table mail_provider_domains');
        }

        $domainsThatShouldBeCheckedOnTypo = [
            [MailProviderDomain::DOMAIN_NAME => 'hotmail', MailProviderDomain::TLD => '["com", "nl", "con", "co", "vom", "cm", "no", "pl", "ca", "de", "fr"]', MailProviderDomain::POPULAR => true, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'gmail', MailProviderDomain::TLD => '["com", "nl", "con", "co", "vom", "cm", "it"]', MailProviderDomain::POPULAR => true, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'yahoo', MailProviderDomain::TLD => '["com", "ie", "in", "ro", "nl", "fr", "de", "es", "be", "at", "dk", "fi", "gr", "se", "it", "pl", "ca"]', MailProviderDomain::POPULAR => true, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'ziggo', MailProviderDomain::TLD => '["nl", "com", "fr", "at", "se"]', MailProviderDomain::POPULAR => true, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'hetnet', MailProviderDomain::TLD => '["nl", "com", "es", "be", "at"]', MailProviderDomain::POPULAR => true, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'upcmail', MailProviderDomain::TLD => '["nl", "be", "pl"]', MailProviderDomain::POPULAR => true, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'versatel', MailProviderDomain::TLD => '["nl", "de"]', MailProviderDomain::POPULAR => true, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'zonnet', MailProviderDomain::TLD => '["nl", "com"]', MailProviderDomain::POPULAR => true, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'kpnmail', MailProviderDomain::TLD => '["nl", "es"]', MailProviderDomain::POPULAR => true, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'planet', MailProviderDomain::TLD => '["nl", "uk", "de", "gr"]', MailProviderDomain::POPULAR => true, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'vodafone', MailProviderDomain::TLD => '["nl", "com", "de", "es", "it"]', MailProviderDomain::POPULAR => true, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'outlook', MailProviderDomain::TLD => '["nl", "com", "fr", "de", "es", "be", "at", "dk", "gr", "se", "it", "pl"]', MailProviderDomain::POPULAR => true, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'telenet', MailProviderDomain::TLD => '["be", "uk", "at", "dk", "fi", "ru"]', MailProviderDomain::POPULAR => true, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'tiscali', MailProviderDomain::TLD => '["nl", "com", "it"]', MailProviderDomain::POPULAR => true, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'telfort', MailProviderDomain::TLD => '["nl", "com", "es", "at", "it", "pl"]', MailProviderDomain::POPULAR => true, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'online', MailProviderDomain::TLD => '["nl", "be", "dk", "gr", "pl", "ru"]', MailProviderDomain::POPULAR => true, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'scarlet', MailProviderDomain::TLD => '["nl", "de", "be", "at"]', MailProviderDomain::POPULAR => true, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'zeelandnet', MailProviderDomain::TLD => '["nl"]', MailProviderDomain::POPULAR => true, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'skynet', MailProviderDomain::TLD => '["be", "fr", "es"]', MailProviderDomain::POPULAR => true, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
        ];

        $domainsThatShouldNotBeCheckedOnTypo = [
            [MailProviderDomain::DOMAIN_NAME => 'hilton', MailProviderDomain::TLD => '["com", "dk"]', MailProviderDomain::POPULAR => false, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'yopmail', MailProviderDomain::TLD => '["com", "fr", "pl"]', MailProviderDomain::POPULAR => false, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'mailbox', MailProviderDomain::TLD => '["org", "uk", "at", "dk", "se", "pl"]', MailProviderDomain::POPULAR => false, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'onsmail', MailProviderDomain::TLD => '["nl"]', MailProviderDomain::POPULAR => false, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'mail', MailProviderDomain::TLD => '["com", "bg", "nl", "fr", "uk", "de", "be", "at", "dk", "fi", "se", "ru"]', MailProviderDomain::POPULAR => false, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'ymail', MailProviderDomain::TLD => '["com", "nl", "be", "dk"]', MailProviderDomain::POPULAR => false, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'email', MailProviderDomain::TLD => '["com", "fr", "it", "ru"]', MailProviderDomain::POPULAR => false, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'onsnet', MailProviderDomain::TLD => '["nu"]', MailProviderDomain::POPULAR => false, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'kickmail', MailProviderDomain::TLD => '["nl"]', MailProviderDomain::POPULAR => false, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'tudelft', MailProviderDomain::TLD => '["nl"]', MailProviderDomain::POPULAR => false, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'tovert', MailProviderDomain::TLD => '["nl"]', MailProviderDomain::POPULAR => false, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'meandernet', MailProviderDomain::TLD => '["nl"]', MailProviderDomain::POPULAR => false, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
            [MailProviderDomain::DOMAIN_NAME => 'meerlanden', MailProviderDomain::TLD => '["nl"]', MailProviderDomain::POPULAR => false, MailProviderDomain::CREATED_AT => now(), MailProviderDomain::UPDATED_AT => now(), ],
        ];

        DB::table('mail_provider_domains')->truncate();

        if (DB::table('mail_provider_domains')->insert(
            array_merge($domainsThatShouldBeCheckedOnTypo, $domainsThatShouldNotBeCheckedOnTypo)
        )
        ) {
            $this->info('Mail Provider Domains seeded successful!');
        } else {
            $this->error('Something went wrong!');
        }

        return 0;
    }
}
