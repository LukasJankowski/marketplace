<?php

namespace Marketplace\Core\Type;

class TypeService
{
    /**
     * @const string[]
     */
    public const TYPES = [
        'customer' => 'customer',
        'provider' => 'provider',
        'admin' => 'admin',
    ];

    /**
     * Check if a given key exists.
     *
     * @param string $type
     *
     * @return bool
     */
    public static function keyExists(string $type): bool
    {
        return array_key_exists($type, self::TYPES);
    }

    /**
     * Check if a given class exists.
     *
     * @param string $class
     *
     * @return bool
     */
    public static function classExists(string $class): bool
    {
        return in_array($class, self::TYPES, true);
    }

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
