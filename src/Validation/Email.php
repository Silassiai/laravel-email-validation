<?php

namespace Silassiai\LaravelEmailValidation\Validation;

use Illuminate\Support\Str;

class Email
{
    /** @var string $domain */
    private string $domain;
    /** @var string $domainName */
    private string $domainName;
    /**
     * top level domain
     * @var string $tld
     */
    private string $tld;

    public function __construct(
        public string $email,
    ) {
        $this->email = strtolower($email);
        $this
            ->setDomain()
            ->setDomainName()
            ->setTopLevelDomain();
    }

    /**
     * @return static
     */
    private function setDomain(): self
    {
        $this->domain = Str::after($this->email, '@');
        return $this;
    }

    /**
     * @return $this
     */
    private function setDomainName(): self
    {
        $this->domainName = Str::before($this->domain, '.');
        return $this;
    }

    /**
     * @return $this
     */
    private function setTopLevelDomain(): self
    {
        $this->tld = Str::after($this->domain, '.');
        return $this;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getDomainName(): string
    {
        return $this->domainName;
    }

    /**
     * @return string
     */
    public function getTld(): string
    {
        return $this->tld;
    }
}