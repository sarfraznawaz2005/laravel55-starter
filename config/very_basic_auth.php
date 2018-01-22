<?php

/**
 * Configuration for the "HTTP Very Basic Auth"-middleware
 */
return [
    // Username
    'user' => 'admin',

    // Password
    'password' => 'admin$123',

    // Environments where the middleware is active
    'envs' => [
        'local',
        'development',
        'test',
        'testing',
        'staging',
        'dev',
        'production',
        'live',
    ],

    // Message to display if the user "opts out"/clicks "cancel"
    'error_message' => 'You have to supply your credentials to access this resource.',

    // If you prefer to use a view with your error message you can uncomment "error_view".
    // This will superseed your default response message
    // 'error_view'        => 'very_basic_auth::default'
];
