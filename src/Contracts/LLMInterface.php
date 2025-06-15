<?php

namespace Hddev\LaravelErrorLab\Contracts;

use Hddev\LaravelErrorLab\Data\ErrorData;

interface LLMInterface
{
    public function suggestFix(ErrorData $errorData, ?string $testCode = null): string;
}
