<?php

namespace Marketplace\Core\Role\ValueObjects;

use Marketplace\Core\Role\RoleService;

class Role
{
    /**
     * Type constructor.
     *
     * @param string $type
     */
    private function __construct(private string $type) {}

    /**
     * Create a new instance of self.
     *
     * @param string $type
     *
     * @return self
     */
    public static function make(string $type): self
    {
        if (!RoleService::slugExists($type)) {
            throw new \InvalidArgumentException(
                sprintf('Unknown type: %s', $type)
            );
        }

        return new self($type);
    }

    /**
     * Get the type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get the class of type.
     *
     * @return string
     */
    public function getClass(): string
    {
        return RoleService::getRoleBySlug($this->type);
    }
}
