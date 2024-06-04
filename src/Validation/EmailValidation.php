<?php

namespace Silassiai\LaravelEmailValidation\Validation;

use Silassiai\LaravelEmailValidation\Services\MailProviderDomainService;

class EmailValidation
{
    /** @var Email $email */
    private Email $email;

    public function __construct(
        private readonly MailProviderDomainService $allProviderDomains,
        private readonly MailProviderDomainService $popularProviderDomains,
        private readonly MailProviderDomainService $excludedProviderDomains,
        // How many characters should be different. If email domain is longer than 5 chars you want to check for max 2 typo\'s instead of 1
        private int $characterDiffLevel = 1,
        private readonly array $validTopLevelDomains = ['com', 'nl', 'fr', 'uk', 'de', 'es', 'be', 'at', 'dk', 'fi', 'gr', 'se', 'it', 'pl', 'ru', 'ca'],
    ) {
    }

    /**
     * The fluent email setter
     * @param string $email
     * @return $this
     */
    public function for(string $email): self
    {
        $this->email = new Email($email);
        return $this;
    }

    /**
     * @return bool
     */
    public function hasValidDomain(): bool
    {
        return $this->allProviderDomains->hasValidDomain($this->email);
    }

    /**
     * Returns the string which should be the typo
     * @return string|null
     */
    public function hasTypo(): ?string
    {
        if ($this->allProviderDomains->hasValidTld($this->email)) {
            // example: (hotmail === hotmail && email toplevel domain is allowed for hotmail) No typo, allowed mail provider
            return null;
        }

        if ($this->hasValidDomain()) {
            // example: (hotmail === hotmail && email toplevel domain is NOT allowed for hotmail), check tld (not found in previous condition)
            // TODO: check if tld looks like one of the valid tlds
            return $this->email->getDomainName();
        }

        $this->setCharacterDiffLevel();


        $typo = $this->popularProviderDomains->search(function ($tlds, $popularDomainName) {
            if (abs(strlen($popularDomainName) - strlen($this->email->getDomainName())) > 1) {
                // Skip if difference is more than 1 character, most likely not a typo
                return false;
            }
            if ($this->foundTypo($popularDomainName)) {
                return true;
            }
            return false;
        });

        if ($typo) {
            return in_array($this->email->getTld(), $this->popularProviderDomains->get($typo) ?: [], true)
                ? $typo . '.' . $this->email->getTld()
                : $typo;
        }
        return null;
    }

    /**
     *
     * @return EmailValidation
     */
    public function setCharacterDiffLevel(): self
    {
        $this->characterDiffLevel = (strlen($this->email->getDomainName()) > 6) ? 2 : 1;
        return $this;
    }

    /**
     * @param string $popularDomainName
     * @return bool
     */
    private function foundTypo(string $popularDomainName): bool
    {
        $emailDomainNameArray = str_split($this->email->getDomainName());
        $popularDomainNameArray = str_split($popularDomainName);

        return count(array_diff($emailDomainNameArray, $popularDomainNameArray)) <= $this->characterDiffLevel
            && count(array_diff($popularDomainNameArray, $emailDomainNameArray)) <= $this->characterDiffLevel
            && $this->passFirstCharacters($emailDomainNameArray, $popularDomainNameArray);
    }

    /**
     * Check if at least one of the first three characters is on the right position
     * Is less than 3 characters, we are passing also
     * @param array $emailDomainNameArray
     * @param array $popularDomainNameArray
     * @return bool
     */
    public function passFirstCharacters(array $emailDomainNameArray, array $popularDomainNameArray): bool
    {
        $emailDomainNameArray = array_slice($emailDomainNameArray, 0, 3);
        $popularDomainNameArray = array_slice($popularDomainNameArray, 0, 3);
        if (count($emailDomainNameArray) < 3 || count($popularDomainNameArray) < 3) {
            return true;
        }

        return (
                $emailDomainNameArray[0] === $popularDomainNameArray[0] && (
                    $emailDomainNameArray[1] === $popularDomainNameArray[1]
                    || $emailDomainNameArray[2] === $popularDomainNameArray[2]
                    || $emailDomainNameArray[1] === $popularDomainNameArray[2]
                    || $emailDomainNameArray[2] === $popularDomainNameArray[1]
                )
            ) || (
                $emailDomainNameArray[1] === $popularDomainNameArray[1] && (
                    $emailDomainNameArray[0] === $popularDomainNameArray[0]
                    || $emailDomainNameArray[2] === $popularDomainNameArray[2]
                    || $emailDomainNameArray[0] === $popularDomainNameArray[2]
                    || $emailDomainNameArray[2] === $popularDomainNameArray[0]
                )
            ) || (
                $emailDomainNameArray[2] === $popularDomainNameArray[2] && (
                    $emailDomainNameArray[0] === $popularDomainNameArray[0]
                    || $emailDomainNameArray[1] === $popularDomainNameArray[1]
                    || $emailDomainNameArray[0] === $popularDomainNameArray[1]
                    || $emailDomainNameArray[1] === $popularDomainNameArray[0]
                )
            );
    }
}