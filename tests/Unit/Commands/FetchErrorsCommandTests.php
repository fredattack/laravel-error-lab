<?php

namespace Hddev\LaravelErrorLab\Tests\Unit\Commands;

use Hddev\LaravelErrorLab\Providers\SentryErrorProvider;
use Hddev\LaravelErrorLab\Tests\TestCase;
use Mockery;

class FetchErrorsCommandTests extends TestCase
{

    protected function tearDown(): void
    {
        // Important: Ferme Mockery après chaque test
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_displays_no_errors_when_provider_returns_empty_array()
    {
        $provider = Mockery::mock(SentryErrorProvider::class);
        $provider->shouldReceive('fetchErrors')->andReturn([]);

        $this->app->instance(SentryErrorProvider::class, $provider);

        $this->artisan('error-lab:fetch-errors')
            ->expectsOutput('0 errors fetched.')
            ->assertExitCode(0);
    }

    /** @test */
    public function it_displays_errors_when_provider_returns_results()
    {
        $provider = Mockery::mock(SentryErrorProvider::class);
        $provider->shouldReceive('fetchErrors')->andReturn([
            [
                'id' => 'err-1',
                'title' => 'Division by zero',
                'culprit' => 'App\\Http\\Controllers\\HomeController@calculate',
                'firstSeen' => now()->subMinutes(10)->toIso8601String(),
                'lastSeen' => now()->toIso8601String(),
                'count' => 5,
            ],
            [
                'id' => 'err-2',
                'title' => 'Undefined variable',
                'culprit' => 'App\\Console\\Kernel',
                'firstSeen' => now()->subHour()->toIso8601String(),
                'lastSeen' => now()->toIso8601String(),
                'count' => 1,
            ],
        ]);

        $this->app->instance(SentryErrorProvider::class, $provider);

        $this->artisan('error-lab:fetch-errors')
            ->expectsOutput('Error: Division by zero (err-1)')
            ->expectsOutput('Error: Undefined variable (err-2)')
            ->expectsOutput('2 errors fetched.')
            ->assertExitCode(0);
    }

    /** @test */
    public function it_uses_the_sentry_provider_by_default()
    {
        $provider = Mockery::mock(SentryErrorProvider::class);
        $provider->shouldReceive('fetchErrors')->once()->andReturn([]);

        $this->app->instance(SentryErrorProvider::class, $provider);

        $this->artisan('error-lab:fetch-errors')
            ->expectsOutput('0 errors fetched.')
            ->assertExitCode(0);
    }

    /** @test */
    public function it_handles_provider_exceptions_gracefully()
    {
        $provider = Mockery::mock(SentryErrorProvider::class);
        $provider->shouldReceive('fetchErrors')->andThrow(new \RuntimeException('Sentry API unreachable'));

        $this->app->instance(SentryErrorProvider::class, $provider);

        $this->artisan('error-lab:fetch-errors')
            ->expectsOutputToContain('Error: Sentry API unreachable')
            ->assertExitCode(1);
    }

    /** @test */
    public function it_accepts_provider_argument()
    {
        // Pour l’instant, seul sentry existe, mais on simule l’argument
        $provider = Mockery::mock(SentryErrorProvider::class);
        $provider->shouldReceive('fetchErrors')->andReturn([
            ['id' => 'abc', 'title' => 'Test error', 'culprit' => '', 'firstSeen' => '', 'lastSeen' => '', 'count' => 1]
        ]);

        $this->app->instance(SentryErrorProvider::class, $provider);

        $this->artisan('error-lab:fetch-errors sentry')
            ->expectsOutput('Error: Test error (abc)')
            ->expectsOutput('1 errors fetched.')
            ->assertExitCode(0);
    }
}
