<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // origin must only include scheme,host and port if it is http://localhost:3000/  it wont work
    'allowed_origins' => [env('FRONT_END_URL')],

    // specifie patterns that is allowed like(if url=http://www.udemy.com we can put here to allow udemy.com or ...)
    'allowed_origins_patterns' => [],

    // allowed headers to send in
    'allowed_headers' => ['*'],

    // headers we want to  exposed with js
    'exposed_headers' => [],

    // catch preflight request ,preflight request = is request browzer make to ask server for permission before sending via across origin request
    // indicate time before re sending a preflight request to the server
    'max_age' => 0,

    // tel laravel to share cookies to the spa
    'supports_credentials' => true,

];
