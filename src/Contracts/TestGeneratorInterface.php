<?php

namespace Hddev\LaravelErrorLab\Contracts;

use Hddev\LaravelErrorLab\Data\ErrorDTO;

interface TestGeneratorInterface
{
    public function generateTest(ErrorDTO $errorData): string;
}
