<?php

namespace Sungmee\Hashid;

use Illuminate\Support\ServiceProvider;

class HashidServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Hashid', function () {
                return new Hashid;
            }
        );
    }

    /**
     * @return array
     */
    public function provides()
    {
        return array('Hashid');
    }
}