<?php

namespace Hddev\LaravelErrorLab\Data;

class ErrorData
{
    public function __construct(
        public string $message,
        public string $exceptionClass,
        public string $file,
        public int $line,
        public ?string $stackTrace = null,
        public ?array $requestPayload = null,
        public ?string $timestamp = null,
        public ?array $tags = [],
        public ?string $provider = null, // sentry, bugsnag, etc.
    ) {}
}
