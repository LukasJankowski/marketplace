<?php

namespace Marketplace\Core\Authorization\ValueObjects;

use InvalidArgumentException;
use Marketplace\Core\Authorization\RoleService;

class Role
{
    /**
     * @const string
     */
    public const ADMIN = 'admin';

    /**
     * @const string
     */
    public const CUSTOMER = 'customer';

    /**
     * @const string
     */
    public const PROVIDER = 'provider';

    /**
     * Role constructor.
     *
     * @param string $slug
     */
    private function __construct(private string $slug)
    {
    }

    /**
     * Create a new instance of self.
     *
     * @param string $slug
     *
     * @return self
     */
    public static function make(string $slug): self
    {
        if (!RoleService::slugExists($slug)) {
            throw new InvalidArgumentException(
                sprintf('Unknown type: %s', $slug)
            );
        }

        return new self($slug);
    }

    /**
     * Get the type.
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Get the class of type.
     *
     * @return string
     */
    public function getRole(): string
    {
        return RoleService::getRoleBySlug($this->slug);
    }
}
