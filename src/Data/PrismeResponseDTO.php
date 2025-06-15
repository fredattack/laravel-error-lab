<?php

namespace Hddev\LaravelErrorLab\Data;

class PrismeResponseDTO
{
    public function __construct(
        public ?string $fix = null,
        public ?string $explanation = null,
        public ?string $phpunit = null,
        public ?array $raw = [],
        public ?string $error = null, // chaîne si erreur technique/API/parsing
    ) {}
}
