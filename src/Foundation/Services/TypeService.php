<?php

namespace Marketplace\Foundation\Services;

use Marketplace\Core\Data\Admin\Admin;
use Marketplace\Core\Data\Customer\Customer;
use Marketplace\Core\Data\Provider\Provider;

class TypeService
{
    /**
     * @const string[]
     */
    public const TYPES = [
        'customer' => Customer::class,
        'provider' => Provider::class,
        'admin' => Admin::class,
    ];

    /**
     * Get the class by key.
     *
     * @param string $type
     *
     * @return string
     */
    public static function getClassByKey(string $type): string
    {
        return self::TYPES[$type] ?? throw new \InvalidArgumentException(
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
    public static function getKeyByClass(string $class): string
    {
        return array_flip(self::TYPES)[$class] ?? throw new \InvalidArgumentException(
            sprintf('Unknown class: %s', $class)
        );
    }

    /**
     * Get the keys.
     *
     * @param array $except
     *
     * @return array
     */
    public static function getKeys(array $except = []): array
    {
        return array_diff(array_keys(self::TYPES), $except);
    }

    /**
     * Get the classes.
     *
     * @param array $except
     *
     * @return array
     */
    public static function getClasses(array $except = []): array
    {
        return array_diff(array_values(self::TYPES), $except);
    }

    /**
     * Get the route regex for where clauses.
     *
     * @param array $except
     *
     * @return string
     */
    public static function getRouteRegexFromKeys(array $except = []): string
    {
        return sprintf('^(?:%s)$', implode('|', self::getKeys($except)));
    }
}
