<?php

namespace Marketplace\Core\Role;

use InvalidArgumentException;
use Marketplace\Core\Role\ValueObjects\Role;
use Marketplace\Core\User\User;

class RoleService
{
    /**
     * @const array<string, string>
     */
    public const ROLES = [
        'customer' => Role::CUSTOMER,
        'provider' => Role::PROVIDER,
        'admin' => Role::ADMIN,
    ];

    /**
     * Check if a given key exists.
     *
     * @param string $type
     *
     * @return bool
     */
    public static function slugExists(string $type): bool
    {
        return array_key_exists($type, self::ROLES);
    }

    /**
     * Check if a given class exists.
     *
     * @param string $class
     *
     * @return bool
     */
    public static function roleExists(string $class): bool
    {
        return in_array($class, self::ROLES, true);
    }

    /**
     * Get the class by key.
     *
     * @param string $type
     *
     * @return string
     */
    public static function getRoleBySlug(string $type): string
    {
        return self::ROLES[$type] ?? throw new InvalidArgumentException(
                sprintf('Unknown type: %s', $type)
            );
    }

    /**
     * Get the key by class
     *
     * @param string $class
     *
     * @return string
     */
    public static function getSlugByRole(string $class): string
    {
        return array_flip(self::ROLES)[$class] ?? throw new InvalidArgumentException(
                sprintf('Unknown class: %s', $class)
            );
    }

    /**
     * Get the classes.
     *
     * @param array<string> $except
     *
     * @return array<string>
     */
    public static function getRoles(array $except = []): array
    {
        return array_diff(array_values(self::ROLES), $except);
    }

    /**
     * Get the route regex for where clauses.
     *
     * @param array<string> $except
     *
     * @return string
     */
    public static function getRouteRegexFromSlugs(array $except = []): string
    {
        return sprintf('^(?:%s)$', implode('|', self::getSlugs($except)));
    }

    /**
     * Get the keys.
     *
     * @param array<string> $except
     *
     * @return array<string>
     */
    public static function getSlugs(array $except = []): array
    {
        return array_diff(array_keys(self::ROLES), $except);
    }

    /**
     * Get the users role.
     *
     * @param User $user
     *
     * @return string
     */
    public static function getRoleOfUser(User $user): string
    {
        return $user->getAttribute('role');
    }
}
