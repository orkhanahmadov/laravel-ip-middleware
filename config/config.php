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
    | Custom server parameter
    |--------------------------------------------------------------------------
    |
    | By default, if this configuration value is set to null middleware will use
    | $_SERVER['REMOTE_ADDR'] parameter to get client IP. If you want to get IP
    | address from different $_SERVER parameter you can set it here.
    |
    | For example, if application is behind "CloudFlare" proxy, then 'REMOTE_ADDR'
    | won't return real client IP, instead CloudFlare sets special
    | $_SERVER['HTTP_CF_CONNECTING_IP'] parameter. You need to set following
    | configuration to that parameter name.
    | 'custom_server_parameter' => 'HTTP_CF_CONNECTING_IP',
    |
    */

    'custom_server_parameter' => null,
];
