<?php

use Illuminate\Http\Response;

return [
    /*
    |--------------------------------------------------------------------------
    | Ignore environments
    |--------------------------------------------------------------------------
    |
    | Environments put in this list will be ignore by middleware.
    |
    */

    'ignore_environments' => [
        'local',
    ],

    /*
    |--------------------------------------------------------------------------
    | Error code
    |--------------------------------------------------------------------------
    |
    | Error code when request gets rejected.
    | Default is 403 (Forbidden).
    |
    */

    'error_code' => Response::HTTP_FORBIDDEN,

    /*
    |--------------------------------------------------------------------------
    | Custom server variable
    |--------------------------------------------------------------------------
    |
    | If application uses proxy service like "CloudFlare" then client IP address
    | will not return real IP address. These services set specific $_SERVER variable
    | with real client IP address.
    | You need to set following configuration to that variable name.
    |
    | For example,
    | "CloudFlare" sets special "HTTP_CF_CONNECTING_IP" variable for all incoming requests:
    | 'custom_server_variable' => 'HTTP_CF_CONNECTING_IP',
    |
    */

    'custom_server_variable' => null,
];
