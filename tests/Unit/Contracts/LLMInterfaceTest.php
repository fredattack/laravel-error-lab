<?php

use Hddev\LaravelErrorLab\Contracts\LLMInterface;
use Hddev\LaravelErrorLab\Data\ErrorData;

it('can implement LLMInterface', function () {
    $mock = new class implements LLMInterface
    {
        public function suggestFix(ErrorData $errorData, ?string $testCode = null): string
        {
            return '// suggested fix';
        }
    };

    $result = $mock->suggestFix(
        new ErrorData(
            message: 'Some error',
            exceptionClass: \Exception::class,
            file: 'file.php',
            line: 10
        )
    );

    expect($result)->toBeString()->toContain('//');
});
