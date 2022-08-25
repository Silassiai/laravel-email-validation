<?php

namespace Silassiai\LaravelEmailValidation;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Silassiai\LaravelEmailValidation\Commands\SeedMailProviderDomains;
use Silassiai\LaravelEmailValidation\Models\MailProviderDomain;
use Silassiai\LaravelEmailValidation\Services\MailProviderDomainService;
use Silassiai\LaravelEmailValidation\Validation\EmailValidation;

class EmailValidationServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        if (app()->runningInConsole()) {
            $this
                ->registerMigrations()
                ->registerCommands();
        }
    }

    public function register(): void
    {
        $this->app->singleton(
            EmailValidation::class,
            fn($app) => new EmailValidation(
                Cache::rememberForever(
                    MailProviderDomain::class,
                    static fn() => new MailProviderDomainService(
                        MailProviderDomain::all()->pluck(MailProviderDomain::TLD, MailProviderDomain::DOMAIN_NAME)
                    )
                ),
                Cache::rememberForever(
                    MailProviderDomain::class . MailProviderDomain::POPULAR,
                    static fn() => new MailProviderDomainService(
                        MailProviderDomain::popular()->pluck(MailProviderDomain::TLD, MailProviderDomain::DOMAIN_NAME)
                    )
                ),
                Cache::rememberForever(
                    MailProviderDomain::class . MailProviderDomain::EXCLUDED,
                    static fn() => new MailProviderDomainService(
                        MailProviderDomain::excluded()->pluck(MailProviderDomain::TLD, MailProviderDomain::DOMAIN_NAME)
                    )
                )
            )
        );
    }

    public function registerMigrations(): self
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        return $this;
    }

    public function registerCommands(): self
    {
        $this->commands([
            SeedMailProviderDomains::class,
        ]);
        return $this;
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [EmailValidation::class, EmailValidation::class];
    }
}