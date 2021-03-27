<?php

namespace Marketplace\Core\Authorization\ValueObjects;

use InvalidArgumentException;
use Marketplace\Core\Authorization\RoleService;
use Marketplace\Foundation\ValueObjects\ValueObject;

class Role extends ValueObject
{
    public const ADMIN = 'admin';

    public const CUSTOMER = 'customer';

    public const PROVIDER = 'provider';

    /**
     * Role constructor.
     */
    private function __construct(private string $slug)
    {
    }

    /**
     * Create a new instance of self.
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
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Get the class of type.
     */
    public function value(): string
    {
        return RoleService::getRoleBySlug($this->slug);
    }
}
