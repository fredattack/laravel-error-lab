<?php

namespace Hddev\LaravelErrorLab\Tests\Unit\Contracts;

use Hddev\LaravelErrorLab\Contracts\LLMInterface;
use Hddev\LaravelErrorLab\Data\ErrorDTO;
use Hddev\LaravelErrorLab\Tests\TestCase;

class LLMInterfaceTest extends TestCase
{
    public function test_can_implement_llm_interface()
    {
        $mock = new class implements LLMInterface
        {
            public function suggestFix(ErrorDTO $errorData, ?string $testCode = null): string
            {
                return '// suggested fix';
            }
        };

        $result = $mock->suggestFix(
            new ErrorDTO(
                exceptionClass: \Exception::class,
                message: 'Some error',
                line: 10,
                occurredAt: '2023-01-01 00:00:00',
                environment: 'testing',
                stackTrace: 'Stack trace here',
                url: '/test',
                method: 'GET',
                requestPayload: null,
                requestHeaders: null,
                userInfo: null,
                file: 'file.php',
                class: 'App\\Example',
                methodName: 'test'
            )
        );

        $this->assertIsString($result);
        $this->assertStringContainsString('//', $result);
    }
}
