<?php

namespace Hddev\LaravelErrorLab\Data;

class ErrorDTO
{
    public function __construct(
        public string $exceptionClass,
        public string $message,
        public int $line,
        public string $occurredAt,
        public string $environment,
        public string $stackTrace,
        public string $url,
        public string $method,
        public array|string|null $requestPayload,
        public array|string|null $requestHeaders,
        public ?string $userInfo,
        public string $file,
        public string $class,
        public string $methodName,
    ) {}
}
