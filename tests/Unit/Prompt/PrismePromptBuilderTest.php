<?php

namespace Hddev\LaravelErrorLab\Tests\Unit\Prompt;

use Hddev\LaravelErrorLab\Data\CodeContextDTO;
use Hddev\LaravelErrorLab\Data\ErrorDTO;
use Hddev\LaravelErrorLab\Data\TestCoverageDTO;
use Hddev\LaravelErrorLab\Services\PrismePromptBuilder;
use Illuminate\Contracts\View\Factory as ViewFactory;
use PHPUnit\Framework\TestCase;

// Fake ViewFactory strictement conforme pour les tests
class FakeViewFactory implements ViewFactory
{
    public array $lastVars = [];

    public function make($view, $vars = [], $mergeData = [])
    {
        $this->lastVars = $vars;

        return new class($vars)
        {
            private array $vars;

            public function __construct(array $vars)
            {
                $this->vars = $vars;
            }

            public function render()
            {
                // Pour le test : retour "clé: valeur" pour chaque var
                $lines = [];
                foreach ($this->vars as $k => $v) {
                    $lines[] = "$k: ".(is_array($v) ? json_encode($v) : (string) $v);
                }

                return implode("\n", $lines);
            }
        };
    }

    // Stubs inutilisés
    public function exists($view) {}

    public function file($path, $data = [], $mergeData = []) {}

    public function share($key, $value = null) {}

    public function composer($views, $callback) {}

    public function creator($views, $callback) {}

    public function addNamespace($namespace, $hints) {}

    public function replaceNamespace($namespace, $hints) {}
}

class PrismePromptBuilderTest extends TestCase
{
    protected function makeErrorDTO(array $overrides = []): ErrorDTO
    {
        $defaults = [
            'exceptionClass' => 'ErrorException',
            'message' => 'Undefined variable: foo',
            'line' => 42,
            'occurredAt' => '2025-06-15 12:34:56',
            'environment' => 'production',
            'stackTrace' => "ErrorException: Undefined variable: foo in /app/Example.php:42\n#1 .",
            'url' => '/api/test',
            'method' => 'POST',
            'requestPayload' => ['key' => 'value'],
            'requestHeaders' => ['Accept' => 'application/json'],
            'userInfo' => 'User #1',
            'file' => '/app/Example.php',
            'class' => 'App\\Example',
            'methodName' => 'handle',
        ];
        $d = array_merge($defaults, $overrides);

        return new ErrorDTO(
            $d['exceptionClass'],
            $d['message'],
            $d['line'],
            $d['occurredAt'],
            $d['environment'],
            $d['stackTrace'],
            $d['url'],
            $d['method'],
            $d['requestPayload'],
            $d['requestHeaders'],
            $d['userInfo'],
            $d['file'],
            $d['class'],
            $d['methodName'],
        );
    }

    protected function makeCodeContextDTO(array $overrides = []): CodeContextDTO
    {
        $defaults = [
            'file' => '/app/Example.php',
            'line' => 42,
            'snippet' => '<?php echo $foo; ?>',
        ];
        $d = array_merge($defaults, $overrides);

        return new CodeContextDTO(
            $d['file'],
            $d['line'],
            $d['snippet']
        );
    }

    protected function makeTestCoverageDTO(array $overrides = []): TestCoverageDTO
    {
        $defaults = [
            'isTested' => false,
            'class' => 'App\\Example::handle',
            'method' => 'handle',
            'coveringTests' => [],
        ];
        $d = array_merge($defaults, $overrides);

        return new TestCoverageDTO(
            $d['class'],
            $d['method'],
            $d['isTested'],
            $d['coveringTests'],
        );
    }

    public function test_build_returns_prompt_with_all_variables_replaced()
    {
        $fakeView = new FakeViewFactory;
        $builder = new PrismePromptBuilder($fakeView);

        $prompt = $builder->build(
            $this->makeErrorDTO(),
            $this->makeCodeContextDTO(),
            $this->makeTestCoverageDTO()
        );

        $this->assertStringContainsString('exception_class: ErrorException', $prompt);
        $this->assertStringContainsString('exception_message: Undefined variable: foo', $prompt);
        $this->assertStringContainsString('code_snippet: <?php echo $foo; ?>', $prompt);
        $this->assertStringContainsString('is_tested: non', $prompt);
    }

    public function test_build_handles_tested_and_method()
    {
        $fakeView = new FakeViewFactory;
        $builder = new PrismePromptBuilder($fakeView);

        $coverage = $this->makeTestCoverageDTO([
            'isTested' => true,
            'method' => 'App\\Example::handle',
        ]);

        $prompt = $builder->build(
            $this->makeErrorDTO(),
            $this->makeCodeContextDTO(),
            $coverage
        );

        $this->assertStringContainsString('is_tested: oui', $prompt);
        $this->assertStringContainsString('method: App\\Example::handle', $prompt);
    }

    public function test_build_handles_missing_optional_fields()
    {
        $fakeView = new FakeViewFactory;
        $builder = new PrismePromptBuilder($fakeView);

        $dto = $this->makeErrorDTO([
            'userInfo' => null,
            'requestHeaders' => null,
            'requestPayload' => null,
        ]);

        $prompt = $builder->build(
            $dto,
            $this->makeCodeContextDTO(),
            $this->makeTestCoverageDTO()
        );

        $this->assertStringContainsString('user_info: N/A', $prompt);
        $this->assertStringContainsString('request_headers: null', $prompt);
        $this->assertStringContainsString('request_payload: null', $prompt);
    }
}
