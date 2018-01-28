<?php

return [
    'name' => 'Main',
    'slogan' => '',

    # specify whether to use breadcrumb feature
    'breadcrumb' => false,

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
