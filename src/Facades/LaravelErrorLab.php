<?php

namespace Hddev\LaravelErrorLab\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Hddev\LaravelErrorLab\LaravelErrorLab
 */
class LaravelErrorLab extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Hddev\LaravelErrorLab\LaravelErrorLab::class;
    }
}
