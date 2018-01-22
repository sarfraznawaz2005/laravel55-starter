<?php

return [

    /*
    | Enable or disable query dumper. By default it is disabled.
    */

    'enabled' => env('QUERYLINE', false),

    /*
    | Whatever value for this config is set, you will be able to see quries graph by appending
    | this value in your url as query string.
    |
    | Example: http://www.yourapp.com/someurl?vvv
    */

    'querystring_name' => 'vvv',
];
