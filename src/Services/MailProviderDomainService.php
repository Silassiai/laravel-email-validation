<?php

namespace Silassiai\LaravelEmailValidation\Services;

use http\Exception\BadMethodCallException;
use Illuminate\Support\Collection;
use ReflectionException;
use ReflectionMethod;
use Silassiai\LaravelEmailValidation\Validation\Email;

class MailProviderDomainService
{
    public function __construct(
        private readonly Collection $mailProviderDomains
    ) {
    }

    /**
     * @param Email $email
     * @return mixed
     */
    public function getTlds(Email $email): array
    {
        return $this->mailProviderDomains->get($email->getDomainName()) ?? [];
    }

    /**
     * @param Email $email
     * @return bool
     */
    public function hasValidTld(Email $email): bool
    {
        return in_array($email->getTld(), $this->getTlds($email), true);
    }

    /**
     * @param Email $email
     * @return bool
     */
    public function hasDomain(Email $email): bool
    {
        return $this->mailProviderDomains->has($email->getDomainName());
    }

    /**
     * Collection methods can still get called
     * @throws ReflectionException
     */
    public function __call($method, $args)
    {
        $reflect = new ReflectionMethod($this->mailProviderDomains, $method);
        if (!$reflect->isPublic()) {
            throw new BadMethodCallException();
        }

        return $this->mailProviderDomains->$method(...$args);
    }
}