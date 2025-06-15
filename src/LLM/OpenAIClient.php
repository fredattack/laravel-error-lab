<?php

namespace Hddev\LaravelErrorLab\LLM;

use Exception;
use Hddev\LaravelErrorLab\Contracts\LLMClientInterface;
use Hddev\LaravelErrorLab\Data\PrismeResponseDTO;
use Illuminate\Support\Facades\Http;

class OpenAIClient implements LLMClientInterface
{
    protected string $apiKey;
    protected string $apiUrl;

    public function __construct(string $apiKey, string $apiUrl = 'https://api.openai.com/v1/chat/completions')
    {
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl;
    }

    public function sendPrompt(string $prompt): PrismeResponseDTO
    {
        try {
            $response = Http::withToken($this->apiKey)
                ->post($this->apiUrl, [
                    'model' => 'gpt-4',
                    'messages' => [
                        ['role' => 'system', 'content' => $prompt],
                    ],
                    'max_tokens' => 2048,
                    'temperature' => 0.2,
                ]);

            if (!$response->successful()) {
                return new PrismeResponseDTO(error: 'API Error: '.$response->status().' '.$response->body());
            }

            $data = $response->json();

            // Adapter ce parsing à ta structure attendue
            $content = $data['choices'][0]['message']['content'] ?? null;

            // Ici tu peux tenter d'extraire via regex ou parsing structuré le fix, l'explication, le test...
            // Pour la démo, on retourne tout le contenu dans "explanation"
            return new PrismeResponseDTO(
                explanation: $content,
                raw: $data,
            );
        } catch (Exception $e) {
            return new PrismeResponseDTO(error: $e->getMessage());
        }
    }

    public function sendBatch(array $prompts): array
    {
        return array_map([$this, 'sendPrompt'], $prompts);
    }
}
