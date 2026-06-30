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
     * The non-empty dot-separated labels of the domain
     * @return string[]
     */
    private function labels(): array
    {
        return array_values(array_filter(explode('.', $this->domain), static fn ($label) => $label !== ''));
    }

    /**
     * The registrable domain name: the label left of the top level domain
     * @return $this
     */
    private function setDomainName(): self
    {
        $labels = $this->labels();
        $count = count($labels);
        $this->domainName = $count >= 2 ? $labels[$count - 2] : ($labels[0] ?? '');
        return $this;
    }

    /**
     * The top level domain: the last label of the domain
     * @return $this
     */
    private function setTopLevelDomain(): self
    {
        $labels = $this->labels();
        $count = count($labels);
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