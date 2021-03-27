<?php

namespace Marketplace\Foundation\ValueObjects;

use Stringable;

abstract class ValueObject implements Stringable
{
    /**
     * Getter.
     */
    abstract public function value(): mixed;

    /**
     * Get value as string.
     */
    public function __toString(): string
    {
        return (string) $this->value();
    }
}
