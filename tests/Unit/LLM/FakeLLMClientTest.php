<?php

namespace Hddev\LaravelErrorLab\Tests\Unit\LLM;

use Hddev\LaravelErrorLab\Data\PrismeResponseDTO;
use Hddev\LaravelErrorLab\LLM\FakeLLMClient;
use Hddev\LaravelErrorLab\Tests\TestCase;

class FakeLLMClientTest extends TestCase
{
    public function testReturnsFakeResponseWhenSendingPrompt()
    {
        $client = new FakeLLMClient();
        $response = $client->sendPrompt('Test prompt');

        $this->assertInstanceOf(PrismeResponseDTO::class, $response);
        $this->assertEquals('fake fix', $response->fix);
        $this->assertEquals('fake explanation', $response->explanation);
        $this->assertEquals('fake test', $response->phpunit);
        $this->assertArrayHasKey('prompt', $response->raw);
        $this->assertNull($response->error);
    }

    public function testTracksCallsToSendPrompt()
    {
        $client = new FakeLLMClient();
        $client->sendPrompt('First prompt');
        $client->sendPrompt('Second prompt');

        $this->assertCount(2, $client->calls);
        $this->assertEquals('First prompt', $client->calls[0]);
        $this->assertEquals('Second prompt', $client->calls[1]);
    }

    public function testReturnsErrorResponseWhenForceErrorIsSet()
    {
        $client = new FakeLLMClient();
        $client->forceError = 'API unavailable';
        $response = $client->sendPrompt('Test prompt');

        $this->assertEquals('API unavailable', $response->error);
        $this->assertNull($response->fix);
    }

    public function testReturnsCustomResponseWhenForceResponseIsSet()
    {
        $client = new FakeLLMClient();
        $client->forceResponse = [
            'fix' => 'custom fix',
            'explanation' => 'custom explanation',
            'phpunit' => 'custom test'
        ];
        $response = $client->sendPrompt('Test prompt');

        $this->assertEquals('custom fix', $response->fix);
        $this->assertEquals('custom explanation', $response->explanation);
        $this->assertEquals('custom test', $response->phpunit);
    }

    public function testHandlesBatchPrompts()
    {
        $client = new FakeLLMClient();
        $responses = $client->sendBatch(['Prompt 1', 'Prompt 2']);

        $this->assertCount(2, $responses);
        $this->assertInstanceOf(PrismeResponseDTO::class, $responses[0]);
        $this->assertInstanceOf(PrismeResponseDTO::class, $responses[1]);
        $this->assertCount(2, $client->calls);
    }
}
