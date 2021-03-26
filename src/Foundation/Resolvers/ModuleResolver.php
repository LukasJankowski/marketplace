<?php

namespace Marketplace\Foundation\Resolvers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Marketplace\Foundation\MarketplaceServiceProvider;

class ModuleResolver
{
    /**
     * @const string
     */
    public const ROUTE_FILE_NAME = '/routes.php';

    /**
     * @const string
     */
    public const MIGRATION_DIR_NAME = '/migrations';

    /**
     * @const string
     */
    public const EVENT_SUBSCRIBER_FILE_NAME = '/*Subscriber.php';

    /**
     * ModuleResolver constructor.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(private Filesystem $filesystem)
    {
    }

    /**
     * Get all subscribers from the modules.
     *
     * @param string $parentDir
     * @param string $parentNamespace
     *
     * @return array
     */
    public function resolveSubscribers(
        string $parentDir = MarketplaceServiceProvider::CORE_DIR,
        string $parentNamespace = MarketplaceServiceProvider::CORE_NAMESPACE
    ): array
    {
        $handles = [];

        foreach ($this->getModuleDirs($parentDir) as $moduleDir) {
            $filePattern = $moduleDir . self::EVENT_SUBSCRIBER_FILE_NAME;

            foreach ($this->filesystem->glob($filePattern) as $subscriber) {
                $className = $this->filesystem->name($subscriber);
                $module = $this->filesystem->basename($this->filesystem->dirname($subscriber));

                $handles[] = $parentNamespace . '\\' . $module . '\\' . $className;
            }
        }

        return $handles;
    }

    /**
     * Get all routes from the modules.
     *
     * @param string $parentDir
     *
     * @return array
     */
    public function resolveRoutes(string $parentDir = MarketplaceServiceProvider::CORE_DIR): array
    {
        return $this->getFilesFromModules($parentDir, self::ROUTE_FILE_NAME);
    }

    /**
     * Get all migrations from the modules.
     *
     * @param string $parentDir
     *
     * @return array
     */
    public function resolveData(string $parentDir = MarketplaceServiceProvider::CORE_DIR): array
    {
        return $this->getFilesFromModules($parentDir, self::MIGRATION_DIR_NAME, true);
    }

    /**
     * Get all types from all module directories
     *
     * @param string $parentDir
     * @param string $type
     * @param bool $isDir
     *
     * @return array
     */
    private function getFilesFromModules(string $parentDir, string $type, bool $isDir = false): array
    {
        $handles = [];
        foreach ($this->getModuleDirs($parentDir) as $moduleDir) {
            $file = $moduleDir . $type;
            if ($this->exists($file, $isDir)) {
                $handles[] = $file;
            }
        }

        return $handles;
    }

    /**
     * Get all module directories in the parent directory.
     *
     * @param string $parentDir
     *
     * @return array
     */
    private function getModuleDirs(string $parentDir = MarketplaceServiceProvider::CORE_DIR): array
    {
        return $this->filesystem->directories($parentDir);
    }

    /**
     * Check if the file in question exists / is a valid directory.
     *
     * @param string $file
     * @param bool $isDir
     *
     * @return bool
     */
    private function exists(string $file, bool $isDir = false): bool
    {
        return $isDir
            ? $this->exists($file) && $this->filesystem->isDirectory($file)
            : $this->filesystem->exists($file);
    }
}
