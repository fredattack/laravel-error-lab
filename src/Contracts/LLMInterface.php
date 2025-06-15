<?php

namespace Hddev\LaravelErrorLab\Contracts;

use Hddev\LaravelErrorLab\Data\ErrorDTO;

interface LLMInterface
{
    public function suggestFix(ErrorDTO $errorData, ?string $testCode = null): string;
}
