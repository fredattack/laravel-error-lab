<?php

return [
    'sentry' => [
        'token' => env('SENTRY_TOKEN', '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'),
        'organization' => env('SENTRY_ORGANIZATION_SLUG', 'upengage'),
        'project' => env('SENTRY_PROJECT', 'engage-main-api'),
    ],
];
