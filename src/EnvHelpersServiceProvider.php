<?php

namespace Hohayo\LaravelEnvHelpers;

use Illuminate\Support\ServiceProvider;
use Hohayo\LaravelEnvHelpers\Commands\EnvEditCommand;
use Hohayo\LaravelEnvHelpers\Commands\EnvGetCommand;

class EnvHelpersServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                EnvEditCommand::class,
                EnvGetCommand::class,
            ]);
        }
    }
}
