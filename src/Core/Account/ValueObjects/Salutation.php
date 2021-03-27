<?php

namespace Marketplace\Core\Account\ValueObjects;

use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Marketplace\Foundation\ValueObjects\ValueObject;

class Salutation extends ValueObject
{
    /**
     * @const array<string>
     */
    public const SALUTATIONS = [
        'marketplace.core.data.field.salutation.male',
        'marketplace.core.data.field.salutation.female',
        'marketplace.core.data.field.salutation.other',
    ];

    /**
     * Salutation constructor.
     */
    private function __construct(private ?string $salutation)
    {
    }

    /**
     * Check if salutations are required.
     */
    public static function isSalutationRequired(): bool
    {
        return (bool) Config::get('marketplace.core.data.field.salutations', false);
    }

    /**
     * Create a new instance of self.
     *
     * @throws InvalidArgumentException
     */
    public static function make(?string $salutation): self
    {
        if ($salutation !== null && ! in_array($salutation, self::SALUTATIONS, true)) {
            throw new InvalidArgumentException(
                sprintf('Unknown salutation: %s', $salutation)
            );
        }

        return new self($salutation);
    }

    /**
     * @inheritdoc
     */
    public function value(): ?string
    {
        return $this->salutation;
    }
}
