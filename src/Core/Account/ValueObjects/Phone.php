<?php

namespace Marketplace\Core\Account\ValueObjects;

use Marketplace\Foundation\ValueObjects\ValueObject;

class Phone extends ValueObject
{
    /**
     * Phone constructor.
     */
    public function __construct(private ?string $phone)
    {
    }

    /**
     * Create a new instance of self.
     *
     * @param string|null $phone
     *
     * @return self
     */
    public static function make(?string $phone): self
    {
        return new self($phone);
    }

    /**
     * @inheritdoc
     */
    public function value(): ?string
    {
        return $this->phone;
    }
}
