<?php

namespace Marketplace\Foundation\Resolvers;

use Illuminate\Filesystem\Filesystem;
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
     * ModuleResolver constructor.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(private Filesystem $filesystem) {}

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

    /**
     * Get all types from all module directorie.s
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
}
