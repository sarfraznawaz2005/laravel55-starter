<?php

// Admin Panel
Breadcrumbs::register('admin_panel', function ($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('admin_panel'));
});

// User listing
Breadcrumbs::register('admin_user_listing', function ($breadcrumbs) {
    $breadcrumbs->parent('admin_panel');
    $breadcrumbs->push('Users', route('admin_user_listing'));
});
