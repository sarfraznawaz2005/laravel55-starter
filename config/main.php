<?php

return [
    'name' => 'Main',
    'slogan' => '',
    'theme' => 'default', // available: default, dark, gray, purple, blue, green, red, orange

    # specify whether to use breadcrumb feature
    'breadcrumb' => true,

    'datatable' => [
        # rows per page
        'pageLength' => 20,
        # enable or disable table ordering
        'ordering' => true,
        # auto width for columns
        'autoWidth' => true,
        # show processing loader
        'processing' => true,
        # responsive table
        'responsive' => true,
        # entry length change dropdown
        'bLengthChange' => true,
        # export buttons
        'buttons' => ['export', 'print', 'reset', 'reload'],
    ],
];
