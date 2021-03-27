<?php

namespace Marketplace\Foundation\ValueObjects;

use Stringable;

abstract class ValueObject implements Stringable
{
    /**
     * Getter.
     *
     * @return mixed
     */
    abstract public function value();

    /**
     * Get value as string.
     *
     * @return mixed
     */
    public function __toString(): string
    {
        return (string) $this->value();
    }
}
