<?php

namespace Hddev\LaravelErrorLab\Contracts;

use Hddev\LaravelErrorLab\Data\ErrorData;

interface ErrorProviderInterface
{
    /** @return ErrorData[] */
    public function fetchErrors(): array;
}
