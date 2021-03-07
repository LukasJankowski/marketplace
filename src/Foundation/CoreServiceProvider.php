<?php


namespace Marketplace\Foundation;


use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

final class CoreServiceProvider extends ServiceProvider
{
    /**
     * @const string
     */
    public const CORE_DIR = __DIR__ . '/../Core';

    /**
     * @const string[]
     */
    public const CORE_MODULES = [
        'Info',
        'Auth',
    ];


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->bootCoreModules();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {

    }

    /**
     * Boot the core modules.
     */
    private function bootCoreModules()
    {
        $this->configureApiRateLimiter();

        foreach (self::CORE_MODULES as $module) {
            $this->loadRoutesFrom(self::CORE_DIR . '/' . $module . '/routes.php');
        }
    }

    /**
     * Configure the RateLimiter for APIs.
     */
    private function configureApiRateLimiter()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
