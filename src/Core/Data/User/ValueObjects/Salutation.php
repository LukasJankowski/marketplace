<?php

namespace Marketplace\Core\Data\User\ValueObjects;

class Salutation
{
    /**
     * @const string[]
     */
    public const SALUTATIONS = [
        'marketplace.core.data.field.salutation.male',
        'marketplace.core.data.field.salutation.female',
        'marketplace.core.data.field.salutation.other',
    ];

    /**
     * @const bool
     */
    public const SALUTATION_REQUIRED = false;

    /**
     * Salutation constructor.
     *
     * @param null|string $salutation
     */
    private function __construct(private ?string $salutation) {}

    /**
     * Create a new instance of self.
     *
     * @param null|string $salutation
     *
     * @return self
     *
     * @throws \InvalidArgumentException
     */
    public static function make(?string $salutation): self
    {
        if ($salutation !== null && !in_array($salutation, self::SALUTATIONS, true)) {
            throw new \InvalidArgumentException(
                sprintf('Unknown salutation: %s', $salutation)
            );
        }

        return new self($salutation);
    }

    /**
     * Getter.
     *
     * @return null|string
     */
    public function getSalutation(): ?string
    {
        return $this->salutation;
    }
}
