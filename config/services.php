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
      'facebook' => [
        'client_id' => '352503766195620',
        'client_secret' => '2e4c90cbd4bc7c1e912b3ebebf4477be',
        'redirect' => 'http://localhost:8000/api/auth/google/callback',
    ],
    'google' => [
        'client_id' => '464406376145-7tbjm6umoro3aj95ml6f0psa8gmda900.apps.googleusercontent.com',
        'client_secret' => 'K4C1nHkB86pdZ-HOQv0TwF1J',
        'redirect' => 'http://localhost:8000/api/auth/google/callback',
    ],

];
