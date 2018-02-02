<?php

// Admin Panel
Breadcrumbs::register('admin_panel', function ($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('admin_panel'));
});
