<?php

namespace Hddev\LaravelErrorLab\Contracts;

use Hddev\LaravelErrorLab\Data\ErrorData;

interface TestGeneratorInterface
{
    public function generateTest(ErrorData $errorData): string;
}
