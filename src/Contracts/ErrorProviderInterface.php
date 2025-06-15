<?php

namespace Hddev\LaravelErrorLab\Contracts;

use Hddev\LaravelErrorLab\Data\ErrorDTO;

interface ErrorProviderInterface
{
    /** @return ErrorDTO[] */
    public function fetchErrors(): array;
}
