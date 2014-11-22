<?php namespace Vinelab\Minion;

use Illuminate\Support\ServiceProvider;
use Vinelab\Minion\Console\Commands\RunCommand;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class MinionServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Setup the facade alias
        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Minion', 'Vinelab\Minion\Facade\Minion');
        });

        // add the minion class and command to the app under the vinelab namespace
        $this->app['vinelab.minion'] = $this->app->singleton('Vinelab\Minion\Minion');
        $this->app['vinelab.minion.run'] = $this->app->share(function ($app) {
            return new RunCommand();
        });

        $this->commands('vinelab.minion.run');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
