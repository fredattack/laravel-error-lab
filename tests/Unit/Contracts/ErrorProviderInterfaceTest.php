<?php

namespace Hddev\LaravelErrorLab\Tests\Unit\Contracts;

use Hddev\LaravelErrorLab\Contracts\ErrorProviderInterface;
use Hddev\LaravelErrorLab\Data\ErrorDTO;
use Hddev\LaravelErrorLab\Tests\TestCase;

class ErrorProviderInterfaceTest extends TestCase
{
    public function testCanImplementErrorProviderInterface()
    {
        $mock = new class implements ErrorProviderInterface {
            public function fetchErrors(): array
            {
                return [
                    new ErrorDTO(
                        exceptionClass: \Exception::class,
                        message: 'Example error',
                        line: 42,
                        occurredAt: '2023-01-01 00:00:00',
                        environment: 'testing',
                        stackTrace: 'Stack trace here',
                        url: '/test',
                        method: 'GET',
                        requestPayload: null,
                        requestHeaders: null,
                        userInfo: null,
                        file: 'src/File.php',
                        class: 'App\\Example',
                        methodName: 'test'
                    ),
                ];
            }
        };

        $errors = $mock->fetchErrors();

        $this->assertIsArray($errors);
        $this->assertInstanceOf(ErrorDTO::class, $errors[0]);
    }
}
