<?php

namespace Marketplace\Core\User\ValueObjects;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;
use Marketplace\Foundation\ValueObjects\ValueObject;

class Password extends ValueObject
{
    /**
     * Password constructor.
     */
    private function __construct(
        private string $plainPassword,
        private string $password
    )
    {
    }

    /**
     * Create a new instance of self.
     *
     * @throws InvalidArgumentException
     */
    public static function make(string $password): self
    {
        if (mb_strlen($password) < self::getMinPasswordLength()) {
            throw new InvalidArgumentException('Password too short.');
        }

        return new self($password, Hash::make($password));
    }

    /**
     * Get min required password length.
     */
    public static function getMinPasswordLength(): int
    {
        return (int) Config::get('marketplace.core.data.field.password', 6);
    }

    /**
     * Verify that the hash matches the password.
     */
    public function verify(string $passwordHash): bool
    {
        return Hash::check($this->getPlainPassword(), $passwordHash);
    }

    /**
     * Getter.
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * Getter.
     */
    public function value(): string
    {
        return $this->password;
    }
}
