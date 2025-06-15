<?php

return [
    'error_provider' => \Hddev\LaravelErrorLab\Providers\SentryErrorProvider::class,
    'llm_engine' => \Hddev\LaravelErrorLab\LLM\JunieLLM::class,
    'test_generator' => \Hddev\LaravelErrorLab\Testing\SimpleTestGenerator::class,
];
