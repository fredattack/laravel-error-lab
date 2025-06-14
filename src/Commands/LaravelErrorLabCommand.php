<?php

namespace Hddev\LaravelErrorLab\Commands;

use Illuminate\Console\Command;

class LaravelErrorLabCommand extends Command
{
    public $signature = 'laravel-error-lab';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
