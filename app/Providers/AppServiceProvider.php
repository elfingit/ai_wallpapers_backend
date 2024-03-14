<?php

namespace App\Providers;

use App\Library\Core\Acl\AbilitiesProvider;
use App\Library\Core\Contracts\AbilitiesProviderContract;
use App\Library\Core\Contracts\Services\LoggerServiceContract;
use App\Library\Core\Services\LoggerService;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Elfin\Generator\Providers\GeneratorProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(GeneratorProvider::class);
            $this->app->register(IdeHelperServiceProvider::class);
        }

        $this->app->bind(
            AbilitiesProviderContract::class,
            AbilitiesProvider::class
        );

        $this->app->bind(
            LoggerServiceContract::class,
            LoggerService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $path = config_path('docs');
        $privacy_policy_path = $path . '/privacy_policy_en.php';

        $locale = 'fr';//request()->header('X-App-Locale', 'en');

        if ($locale !== 'en' && file_exists($path . "/privacy_policy_{$locale}.php")) {
            $privacy_policy_path = $path . "/privacy_policy_{$locale}.php";
        }

        $this->mergeConfigFrom($privacy_policy_path, 'privacy_policy');
    }
}
