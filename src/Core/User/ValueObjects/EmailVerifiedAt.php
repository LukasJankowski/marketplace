<?php

namespace Marketplace\Core\User\ValueObjects;

use DateTime;
use Exception;
use InvalidArgumentException;
use Marketplace\Foundation\ValueObjects\ValueObject;

class EmailVerifiedAt extends ValueObject
{
    /**
     * Email constructor.
     */
    public function __construct(private DateTime $emailVerifiedAt)
    {
    }

    /**
     * Create a new instance of self.
     *
     * @throws Exception
     */
    public static function make(string|DateTime $emailVerifiedAt): self
    {
        try {
            $emailVerifiedAt = is_string($emailVerifiedAt)
                ? new DateTime($emailVerifiedAt)
                : $emailVerifiedAt;
        } catch (Exception $exception) {
            throw new InvalidArgumentException('Invalid timestamp.', previous: $exception);
        }

        return new self($emailVerifiedAt);
    }

    /**
     * @inheritDoc
     */
    public function value(): DateTime
    {
        return $this->emailVerifiedAt;
    }
}
