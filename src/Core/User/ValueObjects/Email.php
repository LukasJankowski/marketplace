<?php

namespace Marketplace\Core\User\ValueObjects;

use Marketplace\Foundation\ValueObjects\ValueObject;

class Email extends ValueObject
{
    /**
     * Email constructor.
     *
     * @param string $email
     */
    public function __construct(private string $email)
    {
    }

    /**
     * Create a new instance of self.
     *
     * @param string $email
     *
     * @return $this
     */
    public static function make(string $email): self
    {
        /*
        if (!filter_var($email, \FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Email invalid.');
        }
        */

        return new self($email);
    }

    /**
     * @inheritDoc
     */
    public function value(): string
    {
        return $this->email;
    }
}
