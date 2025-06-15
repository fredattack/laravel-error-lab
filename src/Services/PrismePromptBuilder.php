<?php

namespace Hddev\LaravelErrorLab\Services;

use Hddev\LaravelErrorLab\Data\CodeContextDTO;
use Hddev\LaravelErrorLab\Data\ErrorDTO;
use Hddev\LaravelErrorLab\Data\TestCoverageDTO;
use Illuminate\Contracts\View\Factory as ViewFactory;

class PrismePromptBuilder
{
    protected ViewFactory $view;

    public function __construct(ViewFactory $view)
    {
        $this->view = $view;
    }

    public function build(
        ErrorDTO $error,
        CodeContextDTO $code,
        TestCoverageDTO $coverage
    ): string {
        return $this->view->make('prisme.prompt', [
            'exception_class' => $error->exceptionClass,
            'exception_message' => $error->message,
            'occurred_at' => $error->occurredAt,
            'environment' => $error->environment,
            'stacktrace' => $error->stackTrace,
            'request_url' => $error->url,
            'request_method' => $error->method,
            'request_payload' => $error->requestPayload === null ? 'null' : $error->requestPayload,
            'request_headers' => $error->requestHeaders === null ? 'null' : $error->requestHeaders,
            'user_info' => $error->userInfo ?? 'N/A',
            'file' => $error->file,
            'line' => $error->line,
            'code_snippet' => $code->snippet,
            'class' => $error->class,
            'method' => $coverage->method,
            'is_tested' => $coverage->isTested ? 'oui' : 'non',
            'covering_tests' => is_array($coverage->coveringTests)
                ? implode(', ', $coverage->coveringTests)
                : $coverage->coveringTests,
        ])->render();
    }
}
