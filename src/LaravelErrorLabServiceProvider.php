<?php

namespace Hddev\LaravelErrorLab;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Hddev\LaravelErrorLab\Commands\LaravelErrorLabCommand;

class LaravelErrorLabServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-error-lab')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_error_lab_table')
            ->hasCommand(LaravelErrorLabCommand::class);
    }
}
