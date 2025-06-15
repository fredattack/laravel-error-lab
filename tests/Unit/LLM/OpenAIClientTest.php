<?php

namespace Hddev\LaravelErrorLab\Tests\Unit\LLM;

use Exception;
use Hddev\LaravelErrorLab\Data\PrismeResponseDTO;
use Hddev\LaravelErrorLab\LLM\OpenAIClient;
use Hddev\LaravelErrorLab\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class OpenAIClientTest extends TestCase
{
    public function test_sends_prompt_to_open_aiapi_and_returns_explanation()
    {
        // Mock the HTTP client
        Http::fake([
            'https://api.openai.com/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'This is a test response',
                        ],
                    ],
                ],
            ], 200),
        ]);

        // Create client and send prompt
        $client = new OpenAIClient('fake-api-key');
        $response = $client->sendPrompt('Test prompt');

        // Assert request was sent correctly
        Http::assertSent(function ($request) {
            return $request->url() == 'https://api.openai.com/v1/chat/completions' &&
                   $request->hasHeader('Authorization', 'Bearer fake-api-key') &&
                   isset($request['messages'][0]['content']) &&
                   $request['messages'][0]['content'] == 'Test prompt';
        });

        // Assert response was parsed correctly
        $this->assertInstanceOf(PrismeResponseDTO::class, $response);
        $this->assertEquals('This is a test response', $response->explanation);
        $this->assertNull($response->error);
    }

    public function test_handles_api_errors_correctly()
    {
        // Mock the HTTP client to return an error
        Http::fake([
            'https://api.openai.com/v1/chat/completions' => Http::response([
                'error' => 'Invalid API key',
            ], 401),
        ]);

        // Create client and send prompt
        $client = new OpenAIClient('invalid-api-key');
        $response = $client->sendPrompt('Test prompt');

        // Assert error was captured
        $this->assertNotNull($response->error);
        $this->assertStringContainsString('API Error: 401', $response->error);
    }

    public function test_handles_exceptions_gracefully()
    {
        // Mock the HTTP client to throw an exception
        Http::fake(function () {
            throw new Exception('Connection error');
        });

        // Create client and send prompt
        $client = new OpenAIClient('fake-api-key');
        $response = $client->sendPrompt('Test prompt');

        // Assert exception was captured
        $this->assertEquals('Connection error', $response->error);
    }

    public function test_handles_batch_prompts_correctly()
    {
        // Mock the HTTP client
        Http::fake([
            'https://api.openai.com/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Response',
                        ],
                    ],
                ],
            ], 200),
        ]);

        // Create client and send batch prompts
        $client = new OpenAIClient('fake-api-key');
        $responses = $client->sendBatch(['Prompt 1', 'Prompt 2']);

        // Assert responses were returned
        $this->assertCount(2, $responses);
        $this->assertInstanceOf(PrismeResponseDTO::class, $responses[0]);
        $this->assertInstanceOf(PrismeResponseDTO::class, $responses[1]);

        // Assert requests were sent
        Http::assertSentCount(2);
    }
}
