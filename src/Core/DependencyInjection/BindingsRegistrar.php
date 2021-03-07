<?php


namespace Marketplace\Core\DependencyInjection;


use Illuminate\Contracts\Foundation\Application;

final class BindingsRegistrar
{
    /**
     * @var Application
     */
    private Application $app;

    /**
     * BindingsRegistrar constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Bind an abstract service to a concrete implementation.
     *
     * @param string $abstract
     * @param mixed $concrete
     *
     * @return void
     */
    public function bind(string $abstract, mixed $concrete): void
    {
        $this->app->bind($abstract, $concrete);
    }
}
