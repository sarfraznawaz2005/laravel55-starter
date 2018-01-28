<?php

return [
    'name' => 'User',

    # Allow user registration
    'allow_user_registration' => true,
    # whether user should verify their account via email first
    'account_email_verification' => true,
    # whether user should automatically be activated after registration
    'activate_user_on_registration' => true,
    # Show/Hide remember me checkbox on login page
    'remember_me_checkbox' => true,
    # Define which route to redirect to after login
    'redirect_route_after_login' => '/home',
    # Define which route to redirect to after registration
    'redirect_route_after_register' => '/home',
];
