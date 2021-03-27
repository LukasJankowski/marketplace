<?php

namespace Marketplace\Core\Authorization;

use InvalidArgumentException;
use Marketplace\Core\Authorization\ValueObjects\Role;
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
     * Check if a given slug exists.
     */
    public static function slugExists(string $slug): bool
    {
        return array_key_exists($slug, self::ROLES);
    }

    /**
     * Check if a given role exists.
     */
    public static function roleExists(string $role): bool
    {
        return in_array($role, self::ROLES, true);
    }

    /**
     * Get the class by slug.
     */
    public static function getRoleBySlug(string $slug): string
    {
        return self::ROLES[$slug] ?? throw new InvalidArgumentException(
            sprintf('Unknown type: %s', $slug)
        );
    }

    /**
     * Get the slug by class.
     */
    public static function getSlugByRole(string $role): string
    {
        return array_flip(self::ROLES)[$role] ?? throw new InvalidArgumentException(
            sprintf('Unknown class: %s', $role)
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
     * Get the slugs.
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
     */
    public static function getRoleOfUser(User $user): string
    {
        return $user->getAttribute('role');
    }
}
