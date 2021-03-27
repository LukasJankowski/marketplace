<?php

namespace Marketplace\Foundation\Resolvers;

use Illuminate\Filesystem\Filesystem;
use Marketplace\Foundation\MarketplaceServiceProvider;

class ModuleResolver
{
    public const ROUTE_FILE_NAME = '/routes.php';

    public const MIGRATION_DIR_NAME = '/migrations';

    public const EVENT_SUBSCRIBER_DIR_NAME = '/Subscribers';

    public const COMMAND_DIR_NAME = '/Commands';

    /**
     * ModuleResolver constructor.
     */
    public function __construct(private Filesystem $filesystem)
    {
    }

    /**
     * Get all types from all module directories.
     *
     * @return array<string>
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
     * @return array<string>
     */
    private function getModuleDirs(string $parentDir = MarketplaceServiceProvider::CORE_DIR): array
    {
        return $this->filesystem->directories($parentDir);
    }

    /**
     * Check if the file in question exists / is a valid directory.
     */
    private function exists(string $file, bool $isDir = false): bool
    {
        return $isDir
            ? $this->exists($file) && $this->filesystem->isDirectory($file)
            : $this->filesystem->exists($file);
    }

    /**
     * Resolve the files from the directories as classes.
     *
     * @param array<string> $directories
     */
    private function resolveFilesAsClasses(
        array $directories,
        string $parentNamespace = MarketplaceServiceProvider::CORE_NAMESPACE
    ): array
    {
        $handles = [];

        foreach ($directories as $directory) {
            $module = $this->filesystem->basename($this->filesystem->dirname($directory));
            $componentDir = $this->filesystem->basename($directory);

            foreach ($this->filesystem->files($directory) as $subscriber) {
                $className = $this->filesystem->name($subscriber);

                $handles[] = $parentNamespace . '\\' . $module . '\\' . $componentDir . '\\' . $className;
            }
        }

        return $handles;
    }


    /**
     * Get all routes from the modules.
     *
     * @return array<string>
     */
    public function resolveRoutes(string $parentDir = MarketplaceServiceProvider::CORE_DIR): array
    {
        return $this->getFilesFromModules($parentDir, self::ROUTE_FILE_NAME);
    }

    /**
     * Get all migrations from the modules.
     *
     * @return array<string>
     */
    public function resolveData(string $parentDir = MarketplaceServiceProvider::CORE_DIR): array
    {
        return $this->getFilesFromModules($parentDir, self::MIGRATION_DIR_NAME, true);
    }

    /**
     * Get all subscribers from the modules.
     *
     * @return array<string>
     */
    public function resolveSubscribers(
        string $parentDir = MarketplaceServiceProvider::CORE_DIR,
        string $parentNamespace = MarketplaceServiceProvider::CORE_NAMESPACE
    ): array
    {
        $subscriberDirs = $this->getFilesFromModules($parentDir, self::EVENT_SUBSCRIBER_DIR_NAME, true);

        return $this->resolveFilesAsClasses($subscriberDirs, $parentNamespace);
    }

    /**
     * Get all commands from the modules.
     *
     * @return array<string>
     */
    public function resolveCommands(
        string $parentDir = MarketplaceServiceProvider::CORE_DIR,
        string $parentNamespace = MarketplaceServiceProvider::CORE_NAMESPACE
    ): array
    {
        $commandDirs = $this->getFilesFromModules($parentDir, self::COMMAND_DIR_NAME, true);

        return $this->resolveFilesAsClasses($commandDirs, $parentNamespace);
    }
}
