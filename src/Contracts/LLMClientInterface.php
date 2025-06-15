<?php

namespace Hddev\LaravelErrorLab\Contracts;

use Hddev\LaravelErrorLab\Data\PrismeResponseDTO;

interface LLMClientInterface
{
    /**
     * Envoie un prompt à l'IA et retourne la réponse brute.
     */
    public function sendPrompt(string $prompt): PrismeResponseDTO;

    /**
     * (optionnel) Envoie plusieurs prompts en batch, retourne un tableau de réponses.
     */
    public function sendBatch(array $prompts): array;
}
