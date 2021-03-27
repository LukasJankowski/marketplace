<?php

namespace Marketplace\Core\Account\ValueObjects;

use Marketplace\Foundation\ValueObjects\ValueObject;

class Name extends ValueObject
{
    /**
     * Name constructor.
     *
     * @param string $name
     */
    public function __construct(private string $name)
    {
    }

    /**
     * Create a new instance of self.
     *
     * @param string $name
     *
     * @return self
     */
    public static function make(string $name): self
    {
        return new self($name);
    }

    /**
     * @inheritdoc
     */
    public function value(): string
    {
        return $this->name;
    }
}
