<?php

use Hddev\LaravelErrorLab\Contracts\TestGeneratorInterface;
use Hddev\LaravelErrorLab\Data\ErrorData;

it('can implement TestGeneratorInterface', function () {
    $mock = new class implements TestGeneratorInterface
    {
        public function generateTest(ErrorData $errorData): string
        {
            return '// test code';
        }
    };

    $result = $mock->generateTest(new ErrorData(
        message: 'Exception message',
        exceptionClass: \RuntimeException::class,
        file: 'SomeFile.php',
        line: 77
    ));

    expect($result)->toBeString()->toContain('//');
});
