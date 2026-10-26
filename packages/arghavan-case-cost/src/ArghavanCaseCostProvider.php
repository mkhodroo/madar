<?php

namespace Arghavan\CaseCost;

use Illuminate\Support\ServiceProvider;

class ArghavanCaseCostProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/case_cost_config.php', 'case_cost_config');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__. '/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadViewsFrom(__DIR__. '/Views', 'CaseCostView');
    }
}
