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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'facility_api' => [
        'url' => env('FACILITY_API_URL', 'https://hotel.soliera-hotel-restaurant.com/api/facilities'),
        'base_url' => env('FACILITY_API_BASE_URL', 'https://hotel.soliera-hotel-restaurant.com/'),
        'token' => env('FACILITY_API_TOKEN'),
    ],

    'soliera_hotel_api' => [
        'base_url' => env('SOLIERA_HOTEL_API_BASE_URL', 'https://hotel.soliera-hotel-restaurant.com'),
        'token' => env('SOLIERA_HOTEL_API_TOKEN'),
    ],

    // Standardized Soliera API config (preferred)
    'soliera' => [
        'base_url' => env('SOLIERA_API_BASE_URL', env('SOLIERA_HOTEL_API_BASE_URL', 'https://hotel.soliera-hotel-restaurant.com')),
        'token' => env('SOLIERA_API_TOKEN', env('SOLIERA_HOTEL_API_TOKEN')),
    ],

    // Soliera Admin API for data synchronization
    'soliera_admin' => [
        'base_url' => env('SOLIERA_ADMIN_API_URL', 'https://admin.soliera-hotel-restaurant.com'),
        'token' => env('SOLIERA_ADMIN_API_TOKEN'),
        'timeout' => env('SOLIERA_ADMIN_API_TIMEOUT', 30),
    ],

    // Soliera Restaurant API for facility requests
    'soliera_restaurant' => [
        'base_url' => env('SOLIERA_RESTAURANT_API_URL', 'https://restaurant.soliera-hotel-restaurant.com'),
        'facility_request_get' => '/API/Event/Event_facility_request_GET.php',
        'facility_request_put' => '/API/Event/Event_facility_request_PUT.php',
        'token' => env('SOLIERA_RESTAURANT_API_TOKEN'),
        'timeout' => env('SOLIERA_RESTAURANT_API_TIMEOUT', 30),
    ],

    'recaptcha' => [
        'site_key' => env('RECAPTCHA_SITE_KEY', ''),
        'secret_key' => env('RECAPTCHA_SECRET_KEY', ''),
    ],

]; 