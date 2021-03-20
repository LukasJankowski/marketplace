<?php

namespace Marketplace\Core\User\ValueObjects;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

class Password
{
    /**
     * Password constructor.
     *
     * @param string $plainPassword
     * @param string $password
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
     * @param string $password
     *
     * @return self
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
     *
     * @return int
     */
    public static function getMinPasswordLength(): int
    {
        return (int) Config::get('marketplace.core.data.field.password', 6);
    }

    /**
     * Verify that the hash matches the password.
     *
     * @param string $passwordHash
     *
     * @return bool
     */
    public function verify(string $passwordHash): bool
    {
        return Hash::check($this->getPlainPassword(), $passwordHash);
    }

    /**
     * Getter.
     *
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * Getter.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
