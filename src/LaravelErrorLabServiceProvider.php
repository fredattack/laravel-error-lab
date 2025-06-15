<?php

namespace Hddev\LaravelErrorLab;

use Hddev\LaravelErrorLab\Commands\FetchErrorsCommand;
use Hddev\LaravelErrorLab\Commands\LaravelErrorLabCommand;
use Hddev\LaravelErrorLab\Contracts\ErrorProviderInterface;
use Hddev\LaravelErrorLab\Contracts\LLMInterface;
use Hddev\LaravelErrorLab\Contracts\TestGeneratorInterface;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelErrorLabServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-error-lab') // Nom du tag pour vendor:publish => laravel-error-lab-config
            ->hasConfigFile() // Publie config/laravel-error-lab.php
            ->hasViews() // Facultatif ici, tu peux le retirer si tu n’as pas de vues
            ->hasMigration('create_laravel_error_lab_table') // À garder si tu prévois des migrations
            ->hasCommands([
                LaravelErrorLabCommand::class,
                FetchErrorsCommand::class,
            ]); // Register both commands
    }

    public function bootingPackage(): void
    {
        $this->app->bind(
            ErrorProviderInterface::class,
            config('error-lab.error_provider')
        );

        $this->app->bind(
            LLMInterface::class,
            config('error-lab.llm_engine')
        );

        $this->app->bind(
            TestGeneratorInterface::class,
            config('error-lab.test_generator')
        );
    }
}
