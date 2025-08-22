<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Password confirmation timeout
    |--------------------------------------------------------------------------
    |
    | This value controls the number of seconds before a password confirmation
    | times out and the user is prompted to confirm their password again.
    | Default is 300 seconds (5 minutes).
    |
    */
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 300),
];
