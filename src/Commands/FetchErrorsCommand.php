<?php

namespace Hddev\LaravelErrorLab\Commands;

use Hddev\LaravelErrorLab\Providers\SentryErrorProvider;
use Illuminate\Console\Command;

class FetchErrorsCommand extends Command
{
    protected $signature = 'error-lab:fetch-errors {provider=sentry}';

    protected $description = 'Fetch errors from external provider (default: Sentry)';

    public function handle()
    {
        try {
            // Get the provider name from the argument
            $providerName = $this->argument('provider');

            // For now, we only support Sentry
            // In the future, we could use the provider name to resolve different providers
            $provider = app(SentryErrorProvider::class);

            $errors = $provider->fetchErrors();

            foreach ($errors as $error) {
                $this->line("Error: {$error['title']} ({$error['id']})");
            }

            $this->info(count($errors).' errors fetched.');
            // À terme : persister en base, etc.

            return 0;
        } catch (\Exception $e) {
            $this->line('Error: '.$e->getMessage());

            return 1;
        }
    }
}
