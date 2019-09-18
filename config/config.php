<?php

use Illuminate\Http\Response;

return [
    /*
    |--------------------------------------------------------------------------
    | Ignore environments
    |--------------------------------------------------------------------------
    |
    | Environments put in this list will be ignore by middleware
    |
    */

    'ignore_environments' => [
        'local',
    ],

    'error_code' => Response::HTTP_FORBIDDEN,
];
