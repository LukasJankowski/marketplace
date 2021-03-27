<?php

namespace Marketplace\Foundation\Generators;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Marketplace\Foundation\MarketplaceServiceProvider;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

abstract class BaseGenerator extends GeneratorCommand
{
    /**
     * @inheritdoc
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\\' . Str::plural($this->type);
    }

    /**
     * @inheritdoc
     */
    protected function rootNamespace()
    {
        $ns = $this->option('core')
            ? MarketplaceServiceProvider::CORE_NAMESPACE
            : MarketplaceServiceProvider::MODULE_NAMESPACE;

        return  $ns . '\\' . $this->getModuleInput();
    }

    /**
     * @inheritdoc
     */
    protected function getPath($name)
    {
        $path = $this->option('core')
            ? MarketplaceServiceProvider::CORE_DIR
            : MarketplaceServiceProvider::MODULE_DIR;

        $path = str_replace(
            [
                MarketplaceServiceProvider::CORE_NAMESPACE,
                MarketplaceServiceProvider::MODULE_NAMESPACE
            ],
            $path,
            $name
        );

        return str_replace('\\', '/', $path) . '.php';
    }

    /**
     * @inheritdoc
     */
    protected function getNameInput()
    {
        $name = trim($this->argument('name'));

        return Str::finish($name, $this->type);
    }

    /**
     * Getter.
     *
     * @return string
     */
    protected function getModuleInput()
    {
        return trim($this->argument('module'));
    }

    /**
     * @inheritdoc
     */
    protected function getOptions()
    {
        return [
            ['core', '-c', InputOption::VALUE_NONE, "Indicates that {$this->type} is in the core"],
            ['force', null, InputOption::VALUE_NONE, "Overwrite the {$this->type} if it already exists"]
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, "The name of the {$this->type}"],
            ['module', InputArgument::REQUIRED, "The module of the {$this->type}"]
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getStub(): string
    {
        return __DIR__ . '/stubs/' . Str::lower($this->type) . '.stub';
    }
}
