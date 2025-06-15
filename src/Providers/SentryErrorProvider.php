<?php
namespace Hddev\LaravelErrorLab\Providers;

use Hddev\LaravelErrorLab\Contracts\ErrorProviderInterface;

class SentryErrorProvider implements ErrorProviderInterface
{
    public function fetchErrors(array $params = []): array
    {
        // Get values directly from env with fallbacks from config
        $token = env('SENTRY_TOKEN', config('services.sentry.token'));
        $org   = env('SENTRY_ORGANIZATION_SLUG', config('services.sentry.organization'));
        $proj  = env('SENTRY_PROJECT', config('services.sentry.project'));

        ray($token)->blue();
        ray($org)->blue();
        ray($proj)->blue();

         ray( )->pause();
        $client = new \GuzzleHttp\Client();
        $response = $client->get(
            "https://sentry.io/api/0/projects/{$org}/{$proj}/issues/",
            [
                'headers' => [
                    'Authorization' => "Bearer {$token}",
                    'Accept'        => 'application/json',
                ],
            ]
        );

        $data = json_decode($response->getBody()->getContents(), true);

        // Adapter ce qui est retourné à ton modèle d’erreur standard
        return collect($data)->map(function ($error) {
            return [
                'id' => $error['id'],
                'title' => $error['title'],
                'culprit' => $error['culprit'],
                'firstSeen' => $error['firstSeen'],
                'lastSeen' => $error['lastSeen'],
                'count' => $error['count'],
                // etc.
            ];
        })->toArray();
    }

}
