<?php

namespace Hddev\LaravelErrorLab\LLM;

use Hddev\LaravelErrorLab\Contracts\LLMClientInterface;
use Hddev\LaravelErrorLab\Data\PrismeResponseDTO;

class FakeLLMClient implements LLMClientInterface
{
    public array $calls = [];
    public ?string $forceError = null;
    public array $forceResponse = [];

    public function sendPrompt(string $prompt): PrismeResponseDTO
    {
        $this->calls[] = $prompt;
        if ($this->forceError) {
            return new PrismeResponseDTO(error: $this->forceError);
        }
        return new PrismeResponseDTO(
            fix: $this->forceResponse['fix'] ?? 'fake fix',
            explanation: $this->forceResponse['explanation'] ?? 'fake explanation',
            phpunit: $this->forceResponse['phpunit'] ?? 'fake test',
            raw: ['prompt' => $prompt]
        );
    }

    public function sendBatch(array $prompts): array
    {
        return array_map([$this, 'sendPrompt'], $prompts);
    }
}
