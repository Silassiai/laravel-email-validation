<?php

namespace Silassiai\LaravelEmailValidation\Validation;

class EmailValidation
{
    public const SHOULD_CHECK_ON_TYPO_PREFIX = 'silassiai:mail_provider_domains:should_check_on_typo';
    public const SHOULD_NOT_CHECK_ON_TYPO_PREFIX = 'silassiai:mail_provider_domains:should_not_check_on_typo';

    public function __construct(
        protected readonly string $test
    )
    { }

    public function for(string $email)
    {
        dd(app(static::class, [$email]));
//        return app()
    }

    public function hasTypo(): ?string
    {
        // TODO: if excluded domain, > return null

        // TODO: if included domain, > check on typo
        return 'typo.domain';
    }
}