<?php
namespace Hddev\LaravelErrorLab\Data;

class CodeContextDTO
{
    public function __construct(
        public string $file,
        public int $line,
        public string $snippet // Le code autour de la ligne fautive
    ) {}
}
