<?php

namespace Hddev\LaravelErrorLab\Data;

class TestCoverageDTO
{
    public function __construct(
        public string $class, // Ex: App\Service\MonService
        public string $method, // Ex: handle
        public bool $isTested,
        public array $coveringTests = [] // Ex: ['Feature/Service/MonServiceTest::test_foo']
    ) {}
}
