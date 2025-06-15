<?php


namespace Hddev\LaravelErrorLab\Contracts;

use Hddev\LaravelErrorLab\Data\ErrorDTO;
use Hddev\LaravelErrorLab\Data\CodeContextDTO;
use Hddev\LaravelErrorLab\Data\TestCoverageDTO;

interface PromptBuilderInterface
{
    /**
     * Génère le prompt complet à envoyer à l’IA.
     */
    public function build(
       ErrorDTO $error,
        CodeContextDTO $code,
        TestCoverageDTO $coverage
    ): string;
}
