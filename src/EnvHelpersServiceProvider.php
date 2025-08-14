<?php

namespace hohayo\LaravelEnvHelpers;

use Illuminate\Support\ServiceProvider;
use hohayo\LaravelEnvHelpers\Commands\EnvEditCommand;
use hohayo\LaravelEnvHelpers\Commands\EnvGetCommand;

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
