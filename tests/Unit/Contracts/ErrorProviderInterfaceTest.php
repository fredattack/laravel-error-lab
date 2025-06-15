<?php


use Hddev\LaravelErrorLab\Contracts\ErrorProviderInterface;
use Hddev\LaravelErrorLab\Data\ErrorData;

it('can implement ErrorProviderInterface', function () {
    $mock = new class implements ErrorProviderInterface {
        public function fetchRecentErrors(): array
        {
            return [
                new ErrorData(
                    message: 'Example error',
                    exceptionClass: \Exception::class,
                    file: 'src/File.php',
                    line: 42
                ),
            ];
        }
    };

    $errors = $mock->fetchRecentErrors();

    expect($errors)->toBeArray()
        ->and($errors[0])->toBeInstanceOf(ErrorData::class);
});

