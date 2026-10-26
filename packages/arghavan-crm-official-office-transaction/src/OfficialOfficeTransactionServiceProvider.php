<?php

namespace Arghavan\OfficialOfficeTransaction;

use Illuminate\Support\ServiceProvider;

class OfficialOfficeTransactionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/official_office_transaction_config.php', 'official_office_transaction_config');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__. '/views', 'OfficialOfficeTransaction');
    }
}
