<?php

namespace Hddev\LaravelErrorLab\Tests\Unit\Contracts;

use Hddev\LaravelErrorLab\Contracts\TestGeneratorInterface;
use Hddev\LaravelErrorLab\Data\ErrorDTO;
use Hddev\LaravelErrorLab\Tests\TestCase;

class TestGeneratorInterfaceTest extends TestCase
{
    public function testCanImplementTestGeneratorInterface()
    {
        $mock = new class implements TestGeneratorInterface {
            public function generateTest(ErrorDTO $errorData): string
            {
                return '// test code';
            }
        };

        $result = $mock->generateTest(new ErrorDTO(
            exceptionClass: \RuntimeException::class,
            message: 'Exception message',
            line: 77,
            occurredAt: '2023-01-01 00:00:00',
            environment: 'testing',
            stackTrace: 'Stack trace here',
            url: '/test',
            method: 'GET',
            requestPayload: null,
            requestHeaders: null,
            userInfo: null,
            file: 'SomeFile.php',
            class: 'App\\Example',
            methodName: 'test'
        ));

        $this->assertIsString($result);
        $this->assertStringContainsString('//', $result);
    }
}
