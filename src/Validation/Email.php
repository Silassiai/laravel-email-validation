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
            ->setRegistrableDomain();
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
     * Parse the registrable domain from the non-empty dot-separated labels of
     * the domain: the top level domain is the last label, the domain name the
     * label to its left. Subdomains are ignored.
     * @return $this
     */
    private function setRegistrableDomain(): self
    {
        $labels = array_values(array_filter(explode('.', $this->domain), static fn ($label) => $label !== ''));
        $count = count($labels);
        $this->domainName = $count >= 2 ? $labels[$count - 2] : ($labels[0] ?? '');
        $this->tld = $count >= 2 ? $labels[$count - 1] : '';
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