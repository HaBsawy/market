<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'facebook' => [
        'client_id' => '297107224614950',
        'client_secret' => '316ddefb9c1f32d1641b9c2e8e78aff7',
        'redirect' => 'https://eslamfathy.dev-elsawy.com/public/api/login/facebook/callback',
    ],

    'google' => [
        'client_id' => '473562970450-3f1b8b85u51hilklpeinu16r7iob8jmd.apps.googleusercontent.com',
        'client_secret' => 'HyUgXIgL8Gb13GVPdzqHL0IK',
        'redirect' => 'https://eslamfathy.dev-elsawy.com/public/api/login/google/callback',
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
