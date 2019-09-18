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
];
