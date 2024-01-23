<?php

namespace App\Providers;

use App\Library\Core\Acl\AbilitiesProvider;
use App\Library\Core\Contracts\AbilitiesProviderContract;
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
        }

        $this->app->bind(
            AbilitiesProviderContract::class,
            AbilitiesProvider::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
